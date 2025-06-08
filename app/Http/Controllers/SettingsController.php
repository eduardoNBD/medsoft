<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\{
    Hash,
    Validator,   
};
use App\Models\Setting; 
use App\Models\Specialty; 

class SettingsController extends Controller
{
    public function savePrices(Request $request){   
        foreach ($request->input("lang") as $locale => $translations) { 
            $filePath = resource_path("lang/$locale/subjects.php"); 
            $content = "<?php\n\nreturn " . var_export($translations, true) . ";\n";
            file_put_contents($filePath, $content); 
        }
    
        $sentKeys = array_keys($request->input("key", []));
        $currentKeys = Setting::where('module', 'appointments_prices')->pluck('key')->toArray();
        $keysToDelete = array_diff($currentKeys, $sentKeys);
        
        if (!empty($keysToDelete)) {
            Setting::where('module', 'appointments_prices')
                ->whereIn('key', $keysToDelete)
                ->delete();
        }
 
        foreach ($request->input("key") as $key => $value) {
            $price = $value['price'] ?? 0;
            $time = $value['time'] ?? 0;

            // Guarda el precio
            Setting::updateOrCreate(
                ['key' => $key, 'module' => "appointments_prices"],
                ['value' => json_encode($price)]
            );

            // Guarda el tiempo de consulta
            Setting::updateOrCreate(
                ['key' => $key . '_time', 'module' => "appointments_times"],
                ['value' => json_encode($time)]
            );
        }

        return response()->json(["status" => 1, "message" => __("messages.savePrices")]);
    }   
    
    public function saveSpecialties(Request $request){  
        foreach ($request->input("lang") as $locale => $translations) { 

            $filteredTranslations = array_filter($translations, function ($value) {
                return !is_null($value) && $value !== '';
            });

            $filePath = resource_path("lang/$locale/specialties.php"); 
            $content = "<?php\n\nreturn " . var_export($filteredTranslations, true) . ";\n";
     
            file_put_contents($filePath, $content); 
        }

        foreach ($request->input("lang")['en'] as $key => $item) { 

            Specialty::firstOrCreate(["name" => $key], ["name" => $key]);
        }
       
        return response()->json(["status" => 1, "message" => __("messages.saveSpecialties")]);
    }

    public function saveColors(Request $request){  
        Setting::updateOrCreate(
            ['key' => "colors", 'module' => 'theme'],
            ['value' => json_encode($request->all())]
        );

        $cssContent = "";

        $bgMain = $request->input('bg_main_light_mode', '#ffffff');  
        $bgSecondary = $request->input('bg_secondary_light_mode', '#1e293b'); 
        $bgDarkMain = $request->input('bg_main_dark_mode', '#ffffff');  
        $bgDarkSecondary = $request->input('bg_secondary_dark_mode', '#1e293b');  

        foreach ($request->all() as $key => $color) {
            preg_match('/^(.*?)_(light|dark)_mode$/', $key, $matches);

            if (!empty($matches)) {
                $property = $matches[1];  
                $mode = $matches[2];     

                if (strpos($property, 'button') === 0) { 
                    $hoverColor = $this->darkenColor($color, 20);

                    if ($mode === 'dark') {
                        $cssContent .= ".dark .{$property} {background-color: {$color}; color: #ffffff; transition: background-color 0.3s ease, color 0.3s ease;}";
                        $cssContent .= ".dark .{$property}:hover {background-color: {$hoverColor};}";

                        $cssContent .= ".dark .inverted.{$property} {border-color: {$color}; background-color: #ffffff00;color: $color; transition: background-color 0.3s ease, color 0.3s ease;}";
                        $cssContent .= ".dark .inverted.{$property}:hover {background-color: {$hoverColor};color:#ffffff;}";
                    } else {
                        $cssContent .= ".{$property} {background-color: {$color}; color: #ffffff; transition: background-color 0.3s ease, color 0.3s ease;}";
                        $cssContent .= ".{$property}:hover {background-color: {$hoverColor};}";

                        $cssContent .= ".inverted.{$property} {border-color: {$color}; background-color: #ffffff00; color: $color; transition: background-color 0.3s ease, color 0.3s ease;}";
                        $cssContent .= ".inverted.{$property}:hover {background-color: {$hoverColor};color:#ffffff;}";
                    }
                } elseif (strpos($property, 'input_label_text_focus') !== false) {
                    $baseProperty = 'input_label_text'; // La base siempre será input_label_text
                    $cssProperty = 'color'; // Los labels generalmente afectan el color del texto
    
                    if ($mode === 'dark') {
                        $cssContent .= ".dark .peer:focus ~ .{$baseProperty} {{$cssProperty}: {$color};}";
                    } else {
                        $cssContent .= ".peer:focus ~ .{$baseProperty} {{$cssProperty}: {$color};}";
                    }
                }elseif (strpos($property, '_focus') !== false) {
                    $baseProperty = str_replace('_focus', '', $property); // Elimina "_focus" del nombre
                    $cssProperty = strpos($property, 'text') !== false ? 'color' : 'border-color';
    
                    if ($mode === 'dark') {
                        $cssContent .= ".dark .{$baseProperty}:focus {{$cssProperty}: {$color};}";
                    } else {
                        $cssContent .= ".{$baseProperty}:focus {{$cssProperty}: {$color};}";
                    }
                } elseif (strpos($property, 'hover') !== false) { 
                    $baseProperty = str_replace('_hover', '', $property);
                    $cssProperty = strpos($property, 'text') !== FALSE ? 'color' : 'background-color';

                    if ($mode === 'dark') {
                        $cssContent .= ".dark .{$baseProperty}:hover {{$cssProperty}: {$color};}";
                    } else {
                        $cssContent .= ".{$baseProperty}:hover {{$cssProperty}: {$color};}";
                    }
                } elseif (strpos($property, 'text')  === 0) { 
                    if ($mode === 'dark') {
                        $cssContent .= ".dark .{$property} {color: {$color} !important;}";
                    } else {
                        $cssContent .= ".{$property} {color: {$color} !important;}";
                    }
                } elseif (strpos($property, 'text') !== FALSE) { 
                    if ($mode === 'dark') {
                        $cssContent .= ".dark .{$property} {color: {$color};}";
                    } else {
                        $cssContent .= ".{$property} {color: {$color};}";
                    }
                } elseif (strpos($property, 'border') !== FALSE) { 
                    if ($mode === 'dark') {
                        $cssContent .= ".dark .{$property} {border-color: {$color};}";
                    } else {
                        $cssContent .= ".{$property} {border-color: {$color};}";
                    }
                } else { 
                    if ($mode === 'dark') {
                        $cssContent .= ".dark .{$property} {background-color: {$color};}";
                    } else {
                        $cssContent .= ".{$property} {background-color: {$color};}";
                    }
                }
            }else { 
                $cssContent .= ".{$key} {background-color: {$color};}";
            }
        }
 
        $cssContent .= <<<CSS

        /* Reglas para modo claro */
        ::-webkit-scrollbar {width: 12px;} ::-webkit-scrollbar-track {background-color: {$bgMain};}::-webkit-scrollbar-thumb {background-color: {$bgSecondary}; border-radius: 10px;} aside::-webkit-scrollbar {width: 1px;} aside::-webkit-scrollbar-track {background-color: {$bgMain};}aside::-webkit-scrollbar-thumb {background-color: {$bgSecondary}; border-radius: 10px;} #languaje option:hover {background: {$bgSecondary};}.triangle {width: 0;height: 0;border-left: 8px solid transparent;border-right: 8px solid transparent;border-bottom: 9px solid {$bgMain}; position: relative;}.triangle::after {content: '';position: absolute;top: 1px;left: -7px;width: 0;height: 0;border-left: 7px solid transparent;border-right: 7px solid transparent;border-bottom: 8px solid white;}
        /* Reglas para modo oscuro */
        .dark ::-webkit-scrollbar {width: 12px;} .dark ::-webkit-scrollbar-track {background-color: {$bgDarkSecondary};}.dark ::-webkit-scrollbar-thumb {background-color: {$bgDarkMain}; border-radius: 10px;} .dark aside::-webkit-scrollbar {width: 1px;} .dark aside::-webkit-scrollbar-track {background-color: {$bgDarkSecondary};}.dark aside::-webkit-scrollbar-thumb {background-color: {$bgDarkMain}; border-radius: 10px;} .dark #languaje option:hover {background: {$bgDarkMain};}.dark .triangle {border-bottom: 9px solid {$bgDarkSecondary};}.dark .triangle::after {border-bottom: 8px solid #070F26;}
        CSS;
 
        file_put_contents(resource_path("css/theme.css"), $cssContent);

        return response()->json(["status" => 1, "message" => __("messages.saveColors")]);
    }

    private function darkenColor($hex, $percent){
        $rgb = sscanf($hex, "#%02x%02x%02x");
        $darkerRgb = array_map(function ($channel) use ($percent) {
            return max(0, $channel - ($channel * $percent / 100));
        }, $rgb);

        return sprintf("#%02x%02x%02x", $darkerRgb[0], $darkerRgb[1], $darkerRgb[2]);
    } 

    public function saveLogos(Request $request) { 
        $destinationPath = resource_path('img/brand/');
        $logos = [];
        
        $currentLogos = Setting::select(['value'])->where("key","logos")->first();
        $currentLogos = $currentLogos ? json_decode($currentLogos->value,true) : json_decode('{"logo_light":"", "logo_dark":"", "logo_favicon_light":"", "logo_favicon_dark":"", "logo_public":""}',true);

        foreach (['logo_light', 'logo_dark', 'logo_favicon_light', 'logo_favicon_dark', 'logo_public'] as $key) { 
            if ($request->input("del_{$key}_check") === '1') { 
                $filePath = $destinationPath . $currentLogos[$key];
                if (file_exists($filePath)) {
                    unlink($filePath);  
                }
                $logos[$key] = null;   
            } elseif ($request->hasFile($key) && $request->file($key)->isValid()) {
                $file = $request->file($key);
                $extension = $file->getClientOriginalExtension();
                $fileName = "{$key}.{$extension}";
                $file->move($destinationPath, $fileName);
                $logos[$key] = $fileName;
            }else{
                $logos[$key] = $currentLogos[$key];
            }
        }
        
        Setting::updateOrCreate(
            ['key' => "logos", 'module' => 'logos'],
            ['value' => json_encode($logos)]
        );
    
        return response()->json(["status" => 1, "message" => __("messages.saveLogos")]);
    }
}
 