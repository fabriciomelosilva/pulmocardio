<?php

namespace App\Http\Controllers;

use App\Exercise;
use App\StepByStep;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Storage;
use Response;
use Cache;

const CACHETIME = 3600;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return \View::make("exercise.create");
    }

    public function createQuantity()
    {
        return \View::make("exercise.create-steps-quantity");
    }

    public function storeQuantity(Request $request)
    {
        $quantitySteps = $request->input('quantitySteps');

        return \View::make("exercise.create", compact('quantitySteps'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $exercise = new Exercise;
        $path  = url('/');

        $exerciseName = $request->input('exerciseName');
        $exerciseDescription = $request->input('exerciseDescription');
        $exerciseYoutube = $request->input('exerciseYoutube');
        $treatmentLevel = $request->input('treatmentLevel');
        $exerciseRepetition = $request->input('exerciseRepetition');

        $exercise->name = $exerciseName;
        $exercise->description = $exerciseDescription;
        $exercise->youtube = $exerciseYoutube;
        $exercise->treatmentLevel = $treatmentLevel;
        $exercise->repetition = $exerciseRepetition;
        
        if ($request->hasFile('exerciseVideo')){
            $slug_video = Str::slug($exerciseName.'_exercise_video', '-');
            $video = $request->file('exerciseVideo');
            $extension_video = $video->getClientOriginalExtension();
            $name_video = $slug_video.uniqid("").".".$extension_video;

            //save video in folder
            $exercise_image_path_video = $video->storeAs('videos', $name_video);
            //save video in database
            $exercise->video = $path.'/api/videos/'.$name_video;
        }

        if ($request->hasFile('exerciseImage')){
            $slug_img = Str::slug($exerciseName.'_exercise_img', '-');
            $img = $request->file('exerciseImage');
            $extension_img = $img->getClientOriginalExtension();
            $name_img = $slug_img.uniqid("").".".$extension_img;

            //save img in folder
            $exercise_image_path_img = $img->storeAs('images', $name_img);
            //save img in database
            $exercise->img = $path.'/api/img/'.$name_img;
        }

        $exercise->save();
        Cache::forget('requestAllVideos');

        $imgStep = $request->file('imgStep');
        $descStep = $request->input('descStep');

        for ($i = 0; $i < sizeof($descStep); $i++) {
            if ($request->hasFile('imgStep')){
                $slug_img = Str::slug(substr($descStep[$i], 0, 10).'_descStep_img', '-');
                $extension_img = $imgStep[$i]->getClientOriginalExtension();
                $name_img = $slug_img.uniqid("").".".$extension_img;

                //save img in folder
                $exercise_image_path_img = $path.$imgStep[$i]->storeAs('images', $name_img);
            }
            

            $stepByStep[] = new StepByStep([
                'descStep' => $descStep[$i],
                'order' =>  $i+1,
                'imgStep' => $path.'/api/img/'.$name_img.'?w=240&h=240',
                'title' => 'Passo '.($i+1)
            ]);

        }

        $exercise->stepbysteps()->saveMany($stepByStep);

        return redirect()->route('exercise-create')->with('sucess.message', 'Exercício criado com sucesso :D');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function show(Exercise $exercise)
    {

        $exercises = $exercise->orderBy('treatmentLevel', 'asc')->get();

        return \View::make('exercise.list')->with('exercises', $exercises);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function edit(Exercise $exercise)
    {

        $exercise = Exercise::with(['stepbysteps' => function($query) {
            return $query->orderBy('order', 'asc');
        }])->findOrFail($exercise->id);

        return view('exercise.edit', compact('exercise'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $exercise = Exercise::findOrFail($id);
        $path  = url('/');

        $exerciseName = $request->input('exerciseName');
        $exerciseDescription = $request->input('exerciseDescription');
        $exerciseYoutube = $request->input('exerciseYoutube');
        $treatmentLevel = $request->input('treatmentLevel');
        $exerciseRepetition = $request->input('exerciseRepetition');

        $exercise->name = $exerciseName;
        $exercise->description = $exerciseDescription;
        $exercise->youtube = $exerciseYoutube;
        $exercise->treatmentLevel = $treatmentLevel;
        $exercise->repetition = $exerciseRepetition;


        if ($request->hasFile('exerciseImage')){
            $slug_img = Str::slug($exerciseName.'_exercise_img', '-');
            $img = $request->file('exerciseImage');
            $extension_img = $img->getClientOriginalExtension();
            $name_img = $slug_img.uniqid("").".".$extension_img;

            //save img in folder
            $exercise_image_path_img = $path.$img->storeAs('images', $name_img);
            //save img in database
            $exercise->img = $path.'/api/img/'.$name_img;
        }

        $exercise->update();
        Cache::forget('requestAllVideos');


        $imgStep = $request->file('imgStep');
        $descStep = $request->input('descStep');

        for ($j = 0; $j < sizeof($descStep); $j++) {
            $exercise->stepbysteps()->where('id', $exercise->stepbysteps[$j]->id)->update(['descStep' => $descStep[$j]]);

            if ($request->hasFile('imgStep')){

                if (array_key_exists($j,$request->file('imgStep'))){

                    $slug_img = Str::slug(substr($descStep[$i], 0, 10).'_descStep_img', '-');
                    $extension_img = $imgStep[$j]->getClientOriginalExtension();
                    $name_img[$j] = $slug_img.uniqid("").".".$extension_img;

                    //save img in folder
                    $exercise_image_path_img = $path.$imgStep[$j]->storeAs('images', $name_img[$j]);

                    $exercise->stepbysteps()->where('id', $exercise->stepbysteps[$j]->id)->update(['imgStep' => $path.'/api/img/'.$name_img[$j].'?w=240&h=240']);
                }
            }

        }


        if ($request->has('descStepNew')){

            $imgStep = $request->file('imgStepNew');
            $descStep = $request->input('descStepNew');

            $lastStep = Exercise::with(['stepbysteps' => function($query) {
                return $query->orderBy('order', 'desc')->first();
            }])->findOrFail($exercise->id);

            $lastStepValue = $lastStep->stepbysteps[0]->order;

            $lastStepValue = $lastStepValue + 1;

            for ($i = 0; $i < sizeof($descStep); $i++) {

                if ($request->hasFile('imgStepNew')){
                    $slug_img = Str::slug(substr($descStep[$i], 0, 10).'_descStep_img', '-');
                    $extension_img = $imgStep[$i]->getClientOriginalExtension();
                    $name_img = $slug_img.uniqid("").".".$extension_img;

                    //save img in folder
                    $exercise_image_path_img = $imgStep[$i]->storeAs('images', $name_img);
                }

                $stepByStepNew[] = new StepByStep([
                    'descStep' => $descStep[$i],
                    'order' =>  $lastStepValue,
                    'imgStep' => $path.'/api/img/'.$name_img.'?w=240&h=240',
                    'title' => 'Passo '.$lastStepValue
                ]);

                $lastStepValue++;

            }
            $exercise->stepbysteps()->saveMany($stepByStepNew);
        }

        return redirect()->route('exercise-edit',['id' => $exercise->id])->with('sucess.message', 'Exercício atualizado com sucesso :D');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exercise = Exercise::find($id);
        $exercise->delete();

        return redirect()->route('exercise-list')->with('sucess.message', 'Exercício '.$exercise->name.' foi excluído!');
    }

    function getVideo($path) {

        if (Cache::has('video'.$path)){
            $video = unserialize(Cache::get('video'.$path));
            $response = Response::make($video, 200);
            $response->header('Content-Type', 'video/mp4');

        } else {
            $video = Storage::disk('s3')->get("videos/".$path);
            $response = Response::make($video, 200);
            $response->header('Content-Type', 'video/mp4');
            //Cache::put('video'.$path, serialize($video), CACHETIME); 
            Cache::forever('video'.$path, serialize($video));

        }

        return $response;
    }

    function getAllExercises(){
        //Cache::forget('requestAllVideos');

        if (!Cache::has('requestAllVideos')){
 
            $exercises1 = Exercise::with(['stepbysteps' => function($query) {
                return $query->orderBy('order', 'asc');
            }])->where('treatmentLevel', '=', 't1')->orderBy('id', 'asc')->get();
            
            $exercises2 = Exercise::with(['stepbysteps' => function($query) {
                return $query->orderBy('order', 'asc');
            }])->where('treatmentLevel', '=', 't2')->orderBy('id', 'asc')->get();

            $exercises3 = Exercise::with(['stepbysteps' => function($query) {
                return $query->orderBy('order', 'asc');
            }])->where('treatmentLevel', '=', 't3')->orderBy('id', 'asc')->get();

            $exercises4 = Exercise::with(['stepbysteps' => function($query) {
                return $query->orderBy('order', 'asc');
            }])->where('treatmentLevel', '=', 't4')->orderBy('id', 'asc')->get();
            
            $result['niveis'][0]['title'] = 'Nível 1';
            $result['niveis'][0]['nivelDescription'] = '<p>No n&iacute;vel 1 &eacute; ideal que a pessoa que esteja realizando os exerc&iacute;cios fa&ccedil;a exerc&iacute;cios de expans&atilde;o pulmonar. Que realizem uma respira&ccedil;&atilde;o de forma correta para ter efic&aacute;cia nos exerc&iacute;cios realizados. Os exerc&iacute;cios v&atilde;o ser demostrados da forma mais educativa poss&iacute;vel e de f&aacute;cil compreens&atilde;o</p>';
            $result['niveis'][0]['exercises'] = json_decode(json_encode($exercises1), true);

            $result['niveis'][1]['title'] = 'Nível 2';
            $result['niveis'][1]['nivelDescription'] = '<p>No n&iacute;vel 2, uma vez que aprendeu a &ldquo;respira&ccedil;&atilde;o diafragm&aacute;tica&rdquo; juntamente com movimentos ativos de membros superior (MSS), iremos aprender realizar exerc&iacute;cios respirat&oacute;rios com movimentos ativos de membros inferiores (MMII) em sedesta&ccedil;&atilde;o e bipedesta&ccedil;&atilde;o.</p>';
            $result['niveis'][1]['exercises'] = json_decode(json_encode($exercises2), true);

            $result['niveis'][2]['title'] = 'Nível 3';
            $result['niveis'][2]['nivelDescription'] = '<p>No n&iacute;vel de n&uacute;mero 3 iremos realizar exerc&iacute;cios ativos resistidos em diagonais para membros superiores (MMSS) e exerc&iacute;cios ativos resistidos para membros inferiores (MMII) associados com padr&otilde;es respirat&oacute;rios.</p>';
            $result['niveis'][2]['exercises'] = json_decode(json_encode($exercises3), true);

            $result['niveis'][3]['title'] = 'Nível 4';
            $result['niveis'][3]['nivelDescription'] = '<p>No n&iacute;vel de n&uacute;mero 4 iremos realizar exerc&iacute;cios ativos podendo utilizar instrumentos que podem ajudar a ampliar capacidade respirat&oacute;ria, f&iacute;sica e funcional do indiv&iacute;duo.</p>';
            $result['niveis'][3]['exercises'] = json_decode(json_encode($exercises4), true);
       

            Cache::forever('requestAllVideos', serialize($result));

        } else {
            $result = unserialize(Cache::get('requestAllVideos'));
        }

        return $result;
    }

}
