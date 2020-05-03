<?php

namespace App\Http\Controllers;

use App\Helpers\Guruhelpers;
use App\Interfaces\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenerationController extends Controller
{
    public function names($number) {
        $fullname = request()->input('fullname');
        $names = json_decode(file_get_contents("names.json"));

        $generatedNames = [];
        for($i = 0; $i < $number; $i++){
            $firstname = $names[rand(0 , count($names) - 1)];
            $surname = $names[rand(0 , count($names) - 1)];
            if($fullname == 'false'){
                array_push($generatedNames,$firstname);
            }else{
                $name_and_surname = $firstname . " " . $surname;
                array_push($generatedNames,$name_and_surname);

            }
        }
        return response( array( "message" => "Successful", "names" => $generatedNames));
    }

    public function phones($number) {
        $initials = [
            "0701","0702","07025","07026","07027","07028","07029","0703","0704","0705","0706","0707","0708","0709","0802","0803","0804","0805","0806","0807","0808","0809","9","0810","0811","0812","0813","0814","0815","0816","0817","9","0818","9","0819","0909","9","0908","9","0901","0902","0903","0904","0905","0906","0907"
        ];
        $generatedPhoneNumbers = [];
        for($i = 0; $i < $number; $i++){
            $randomNumber = random_int(0,9999999);
            $phoneNumber = $initials[count($initials) - 1] . $randomNumber;
            array_push($generatedPhoneNumbers,$phoneNumber);
        }
        return response( array( "message" => "Successful", "phones" => $generatedPhoneNumbers));


    }

    public function emails($number) {
        $names = json_decode(file_get_contents("names.json"));

        $providers = [
            "gmail.com","yahoo.com","googlemail.com","rocketmail.com"
        ];
        $generatedEmails = [];
        for($i = 0; $i < $number; $i++){
            $firstname = $names[rand(0 , count($names) - 1)];
            $surname = $names[rand(0 , count($names) - 1)];
            $email = $firstname.".". $surname . "@" . $providers[count($providers) - 1];
            $email = strtolower($email);
                array_push($generatedEmails,$email);
        }
        return response( array( "message" => "Successful", "names" => $generatedEmails));


    }

    public function images($number) {

        $noDuplicate = request()->input('no_duplicate');
        $allFiles = Storage::allFiles("public/images");
        $images = [];
        $generatedImages = [];
        foreach($allFiles as $file){

            $mime =  Storage::getMimeType($file);

            if(Str::contains($mime,"image")){
                array_push($images,stripslashes(url(Storage::url($file))));
            }
        }

        $totalFiles = count($images);
        if($totalFiles <= 0) return response( array( "message" => "No images",), 400 );
        if($number > $totalFiles && $noDuplicate == 'true')  return response( array( "message" => "Sorry we don't have that many. We have just $totalFiles"));

        for($i = 0; $i < $number; $i++){
            $image = $images[rand(0,$totalFiles - 1)];
            array_push($generatedImages,$image);
        }

        return response()->json( array( "message" => "Successful", "images" => $generatedImages),200,[],JSON_UNESCAPED_SLASHES);

    }

    public function backgrounds($number) {
        $noDuplicate = request()->input('no_duplicate');
        $allFiles = Storage::allFiles("public/backgrounds");
        $images = [];
        $generatedImages = [];
        foreach($allFiles as $file){

            $mime =  Storage::getMimeType($file);

            if(Str::contains($mime,"image")){
                array_push($images,stripslashes(url(Storage::url($file))));
            }
        }

        $totalFiles = count($images);
        if($totalFiles <= 0) return response( array( "message" => "No images",), 400 );
        if($number > $totalFiles && $noDuplicate == 'true')  return response( array( "message" => "Sorry we don't have that many. We have just $totalFiles"),400);

        for($i = 0; $i < $number; $i++){
            $image = $images[rand(0,$totalFiles - 1)];
            array_push($generatedImages,$image);
        }

        return response()->json( array( "message" => "Successful", "images" => $generatedImages),200,[],JSON_UNESCAPED_SLASHES);

    }
}

