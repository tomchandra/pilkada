<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;

class ChangePassword extends BaseController
{
   public function getIndex()
   {
      return view('Pages/ChangePassword');
   }

   public function postSave()
   {
      $old_password     = $this->request->getPost('old_password');
      $new_password     = $this->request->getPost('new_password');
      $confirm_password = $this->request->getPost('confirm_password');
      $score            = $this->request->getPost('score');

      $check_old_password = auth()->check([
         'email'    => auth()->user()->email,
         'password' => $old_password,
      ]);

      if (!$check_old_password->isOK()) {
         return redirect()->back()->withInput()->with('errors',  ["Old password not match"]);
      }

      if (intval($score) < 75) {
         return redirect()->back()->withInput()->with('errors',  ["New password must containts 8 or more characters with a mix of letters, numbers & symbols"]);
      }

      if ($old_password == $new_password) {
         return redirect()->back()->withInput()->with('errors',  ["Old password and new password cannot be the same"]);
      }

      if ($new_password !== $confirm_password) {
         return redirect()->back()->withInput()->with('errors',  ["New password and confirm password not match"]);
      }

      $user_provider = auth()->getProvider();
      $user          = $user_provider->findById(auth()->id());
      $user->fill([
         'password' => $new_password,
      ]);

      if ($user_provider->save($user)) {
         session()->setFlashdata('success', 'Password changed successfully');
         return redirect()->back();
      }
   }
}
