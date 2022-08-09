<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\users;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/', function (Request $request) {
    return json_encode(["status"=>true,"message"=>"API Fonctionnel"]);
});

Route::post('/login',function (Request $request) {


    //Détection si l'utilisateur est déjà connecté

    $p = $request->post();
    $u = users::where([
        ['users_login','=',$p['id']],
        ['users_pass','=',$p['pass']]
    ])->first();

    if(empty($u)){
        return json_encode(['status'=>false,"message"=>"Utilisateur pas encore inscrit"]);
    }else{
        session(['users'=>$p['id']]);
        return json_encode(['status'=>true,"message"=>"Connexion réussie","user"=>$u]);
    }
    
});

Route::post('/register',function (Request $request){
    $p = $request->post();

    if(isset($p['id']) && isset($p['pass'])){
        $u = users::where([
            ['users_login','=',$p['id']]
        ])->first();

        if(empty($u)){
            $u = users::create([
                'users_login'=>$p['id'],
                'users_pass'=>$p['pass']
            ]);
            $u->save();
            //Création de session 
            Session::push('users',$p['id']);

            return json_encode(['status'=>true,'message'=>"Utilisateur Inscrit avec succès"]);
        }else{
            
            return json_encode(['status'=>false,'message'=>"Utilisateur déjà inscrit",'user'=>$u]);
        }
    }else{
        return json_encode(['status'=>false,'message'=>"Données d'entrée incorretes"]);
    }
});

Route::delete('/user/{id}',function(Request $request,$id){
    users::where('users_id','=',$id)->delete();
    return json_encode(['status' => true,'message'=>"Utilisateur bien supprimé"]);
});

Route::get('/users',function(Request $request){
    $u = users::select('users_id','users_login')->get();
    return json_encode(['status'=>true,'users'=>$u]);
});

Route::get('/deconnexion',function(Request $request){
    session()->forget('users');
    return json_encode(['status'=>true,'message'=>"Deconnexion réussie"]);
});

Route::get('/status', function(Request $request){
    if(session()->has('users')){
        return json_encode(['status'=>true]);
    }else{
        return json_encode(['status'=>false]);
    }
});