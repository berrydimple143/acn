<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Armanagement;
use App\Domain;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm() {
        $server = 'broome.city';        
        session(['url' => $server]);   
        try {
          $arwebsite = Armanagement::where('domainname', $server)->firstOrFail();
        } catch (ModelNotFoundException $ex) {
          $arwebsite = "Not Found";
        }
        $bg = $this->generateBackground($arwebsite, $server);     
        $menu = $this->generateMenu();    
        return view('auth.login', ['title' => 'Homepage', 'runningbg' => $bg]);
    }

    public function generateMenu() {  
        $number_of_images = 1;  
        date_default_timezone_set('Australia/Sydney');
        $jd=cal_to_jd(CAL_GREGORIAN,date("m"),date("d"),date("Y"));
        $day = (jddayofweek($jd,1)); 
        if ($day == 'Sunday'){
            $number_of_images = $number_of_images + 1;
        }
        $imagefilename = 'Australia' . (((time()/30)%$number_of_images)+1).'.png';
        $currentpage = $_SERVER['REQUEST_URI'];
        $menuanimationselection = array("fadeIn", "fadeInUp", "pulse", "rotateIn", "rotateInDownLeft", "rotateInDownRight", "rotateInUpLeft", "rotateInUpRight", "slideInUp", "zoomIn", "zoomInLeft", "zoomInRight", "zoomInUp");
        $randommenuanimationselection = array_rand($menuanimationselection, 4);
        $menuanimationselection1 = $menuanimationselection[$randommenuanimationselection[0]];
        $menuanimationselection2 = $menuanimationselection[$randommenuanimationselection[1]];
        $menuanimationselection3 = $menuanimationselection[$randommenuanimationselection[2]];
        $menuanimationselection4 = $menuanimationselection[$randommenuanimationselection[3]];
        $menuanimationstring = $menuanimationselection1 . " " . $menuanimationselection2 . " " . $menuanimationselection3 . " " . $menuanimationselection4;
        
        $path = "/var/www/html/44/common/Counter.php";
        if(file_exists($path)){
            include($path);
        }else {
            $errormessage = "WARNING I cannot find the Stats Counter I was expecting " . $path;
            $errorstamp = "SITE " . $_SERVER['HTTP_HOST'] . " FILE " . $_SERVER['SCRIPT_FILENAME'] . " " . date ("D M j G:i:s T Y",time());
            $error = $errormessage . "<br>" . $errorstamp . "<br>" . "<hr>" . "\r\n";
            /*$logfile = "/var/www/html/australianregionalnetwork.com/control/errors/errors.htm";
            $handle = fopen($logfile, 'a+');
            fwrite ($handle, $error);
            fclose($handle);*/
        } 
        session(['imagefilename' => $imagefilename]);   
        session(['menuanimationstring' => $menuanimationstring]);  
        return $menuanimationstring;   
    }

    public function generateBackground($arsite, $server) {  
        $bgcreditstring = "";
        $bgcrediturl = "";
        $runningbg = "";
        $backgroundphotorequired = "YES";
        $defaultbg = "commonimages/backgrounds/default/default.jpg";      
        $currentpage = '';
        $serveruri = $_SERVER["REQUEST_URI"];
        $rootpath = $_SERVER["DOCUMENT_ROOT"];
        $currentpage = $serveruri;
        $vbg = isset($_GET["viewbg"]);
        $longstate = "";
        $domainname = "";
        $location = "";
        $flavor = "";
        $localname = "";
        $googlemeta = '';
        $bingmeta = '';
        if($arsite != "Not Found") {
            $longstate = $arsite->longstate;
            $domainname = $arsite->domainname;
            $location = $arsite->location;
            $flavor = $arsite->flavor;    
            $localname = $arsite->localname;          
            $currentpage = strip_tags(substr($currentpage, 0, 120));
            $currentpageurl = '';
            $currentpageurl = 'http://' . $domainname . $currentpage;            
            if (($currentpage == "/index.php") or ($currentpage == "/")) {                                  
                try {
                  $dom = Domain::where('domain', $server)->firstOrFail();
                  $googlemeta = $dom->googlemeta;
                  $bingmeta = $dom->bingmeta;
                } catch (ModelNotFoundException $ex) {
                  $googlemeta = '';
                  $bingmeta = '';
                }       
            }            
            $bestdir = 'commonimages/backgrounds/locations/' . $location;            
            $bestbg = "commonimages/backgrounds/locations/" . $location . ".jpg";
            $flavorbg = "commonimages/backgrounds/flavors/" . $flavor . ".jpg";            
            $bgfiles = glob($bestdir . '/*.jpg');
            if ($bgfiles) {
                if($vbg) {
                    $viewbg = $_GET['viewbg'];
                    $viewbg = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).]/)", '', $viewbg);
                    if (in_array($viewbg, $bgfiles)) {
                        $runningbg = $viewbg;
                    }
                } else {
                    if (count($bgfiles) > 1) {
                        if (($currentpage == "/") or ($currentpage == "/index.php") or ($currentpage == "/View-Background.php")) {
                        
                        } else {    
                            shuffle($bgfiles);
                        }
                    }
                    $runningbg = $bgfiles[0];   
                }
            } else if (file_exists($flavorbg)) {
                $runningbg = $flavorbg;
                $bgcredit = str_replace(".jpg", ".txt", $runningbg);
                if (file_exists($bgcredit)) {
                    $printbgcredit = "YES";
                    $creditfile = fopen($bgcredit, "r");
                    $creditarray = (fgetcsv($creditfile));
                    fclose($creditfile);
                    $bgcreditstring = $creditarray[0];
                    if (!empty($creditarray[1])) {
                        $bgcrediturl = $creditarray[1];
                    }
                }
            } else {
                $runningbg = $defaultbg;
            }
        } else {
            $runningbg = $defaultbg;
        }
        session(['bgcrediturl' => $bgcrediturl]);
        session(['bgcreditstring' => $bgcreditstring]);
        session(['currentpage' => $currentpage]);
        session(['serveruri' => $serveruri]);
        session(['runningbg' => $runningbg]);
        session(['longstate' => $longstate]);
        session(['location' => $location]);   
        session(['localname' => $localname]);
        session(['rootpath' => $rootpath]);     
        session(['googlemeta' => $googlemeta]);    
        session(['bingmeta' => $bingmeta]);   
        session(['currentpageurl' => $currentpageurl]);   
        session(['server' => $server]);   
        return $runningbg;
    }
}
