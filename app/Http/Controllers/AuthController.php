<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Request;
use App\Models\User;
use Hash;
use Session;

class AuthController extends Controller
{
	public function login(){
  		$password = Request::input('motDePasse', '');
  		$email = Request::input('email', '');
  		$pseudo = Request::input('pseudo', '');

  		// Si l'utilisateur renseigne son pseudo
  		if (!empty($pseudo)){
  			
  			$user = User::where("pseudo", $pseudo)->first();
  			
  			// Vérifie que le pseudo existe dans la BD
  			if (!isset($user)) {
  			   return 'Connexion échouée, pseudo inexistant';
  			}
  			
  			// Vérifie le password et le hash
  			if (!Hash::check($password, $user->motDePasse)) {
      			return 'Connexion échouée, mauvais password';
  			}
  			Session::put('user_id', $user->id);
  			return 'Connexion réussie';
       }
       
  		// Sinon, si l'utilisateur renseigne son email
  		else if (!empty($email)){
  			
  			$user = User::where("email", $email)->first();
  			
  			// Vérifie que l'e-mail existe dans la BD
  			if (!isset($user)) {
  			   return 'Connexion échouée, email inexistant';
  			}
  			
  			// Vérifie le password et le hash
  			if (!Hash::check($password, $user->motDePasse)) {
      			return 'Connexion échouée, mauvais password';
  			}
  			Session::put('user_id', $user->id);
  			return 'Connexion réussie';
       }

	}
	
	public function logout()
	{
    	Session::forget('user_id');
    	return 'Déconnexion réussie';
	}
  // Contrôle la connexion au panneau d'administration
  public function loginAdmin(){
    $fields = Request::only('pseudo', 'motDePasse');
    $user = User::where('pseudo',$fields['pseudo'])->first();
    if (!isset($user)) {
           return 'Aucun user existant avec ce Pseudo';
    }
    // Vérifie le password et le hash
    if (!Hash::check($fields['motDePasse'], $user->motDePasse)) {
      return 'Connexion échouée, mauvais password';
    }

    $groups = $user->groups;
    foreach ($groups as $group) {
      if($group->nom == 'admin'){
        Session::put('user_id', $user->id);
        Session::put('group', $group->nom);
        return 'Connexion admin réussie';
      }
      else{
        return "Vous n'avez pas accès à l'interface admin";
      }
    }

  }
  public function logoutAdmin()
  {
      Session::forget('user_id');
      Session::forget('group');
      return 'Déconnexion réussie';
  }
}
