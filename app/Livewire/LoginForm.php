<?php

namespace App\Livewire;

use Livewire\Component;

class LoginForm extends Component
{
    public $email;
    public $password;
    public $loginErrorMsg = "";

    public function render()
    {
        return view('livewire.login-form');
    }

    public function login() 
    {
        $validated = $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth('web')->attempt($validated)) {
            return redirect()->route('dashboard');
        } else {
            $this->loginErrorMsg = 'Login gagal. Silahkan periksa kembali email dan password';
        }
    }
}
