<?php

namespace JVelletti\JvTyposcript\Utility;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\ExtbaseRequestParameters;
use TYPO3\CMS\Extbase\Mvc\Request;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
class TyposcriptUtility
{
    public static function getPath($pid , $langId , $extension  )
    {
        $site = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Site\SiteFinder::class)->getSiteByPageId($pid);
        $uri = $site->getRouter()->generateUri( $pid , ['tx_jvtyposcript' => $extension , 'L' => $langId , 'no_cache' => 1 ] , '', '' ) ;

        if( isset( $GLOBALS['TYPO3_CONF_VARS']['HTTP']['auth'])) {
           $auth = $GLOBALS['TYPO3_CONF_VARS']['HTTP']['auth'] ;
           if ( is_array( $auth ) && count( $auth ) == 2 ) {
                $uri = str_replace( '://' , '://' . $auth[0] . ':' . $auth[1] . '@' , $uri ) ;
           }
        }

        return $uri;

    }

    public static function loadTypoScriptviaCurl($path )
    {
        $url = trim((string) $path) ;
        $curl = curl_init();

        curl_setopt_array($curl,
           [   CURLOPT_URL => $url,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET'
           ]);

        $response = curl_exec($curl);

        curl_close($curl);
        if( $response ) {
            return json_decode( $response , true ) ;
        }
        return false ;
    }

}