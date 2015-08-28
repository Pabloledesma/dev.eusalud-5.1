<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use LaravelCaptcha\Integration\BotDetectCaptcha;
use Symfony\Component\HttpFoundation\Response;
use function flash;
use function redirect;
use function view;

class PagesController extends Controller 
{
    public function __construct()
    {
        $this->middleware('menu'); 
    }

    /**
     * Show the application welcome screen to the user.
     *  
     * @return Response
     */
    public function index() {
        $user = auth()->user();
        
        return view('info.index');
        //$imagenes = scandir( public_path() . '\img\clientes' ); 
        //return view('welcome.inicio', compact('imagenes', 'user'));
    }
    
    /*
     * Obtiene una instancia de captcha
     * @return captcha
     */
    private function getCaptchaInstance() {
      // Captcha parameters
      $captchaConfig = [
        'CaptchaId'             => 'ExampleCaptcha',    // a unique Id for the Captcha instance
        'UserInputId'           => 'CaptchaCode'       // Id of the Captcha code input textbox                                                 
        //'CaptchaConfigFilePath' => 'captchaConfig\CaptchaConfig.php',
      ];
      $captcha = BotDetectCaptcha::GetCaptchaInstance($captchaConfig);

      return $captcha;
    }

}
