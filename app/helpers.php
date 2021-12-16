<?php 

use App\helpers;
function Authentication()
{
    return public_path('images/products/'.$image_name);
}


if (!function_exists('ok')) {
  function ok()
    {
        return  Basecamp::init([
            'id' => $user->user['accounts'][0]['id'],
            'href' => $user->user['accounts'][0]['href'],
            'token' => $user->token,
            'refresh_token' => $user->refreshToken,
            ]);
    }
}
 



?>

