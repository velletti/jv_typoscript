<?php

namespace JVelletti\JvTyposcript\Middleware;

use JVelletti\JvTyposcript\Utility\EmConfigurationUtility;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Http\Stream;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;
/**
 * Class Typoscript
 * @package JVelletti\JvTyposcript\Middleware
 */
class JvTyposcript implements MiddlewareInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws InvalidExtensionNameException
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface
    {

        $_gp = $request->getQueryParams();
        if( is_array($_gp) && key_exists("tx_jvtyposcript" ,$_gp ) ) {
            if( array_key_exists("no_cache" , $_gp )) {
                $this->getTypoScript($request , $_gp['tx_jvtyposcript']) ;
            } else {
                $url = GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL')  . "&no_cache=1" ;
                return   new RedirectResponse(
                     GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL') . "&no_cache=1" , 307 ,
                     ['Pragma' => 'no-cache' , 'Cache-Control' => 'no-cache' , 'Expires' => '0' ]
                ) ;

            }

        }

        return $handler->handle($request);
    }

    private function getTypoScript($request , $extKey = "all")

    {

        $frontendTs = $request->getAttribute('frontend.typoscript');
        if ( $frontendTs->hasSetup() ) {
            $ts = $frontendTs->getSetupArray();
            if ( ! array_key_exists('plugin.' ,  $ts )) {
                return ;
            }
            $ts['plugin']  = self::removeDotsFromTypoScriptArray($ts['plugin.'] );
        } else {
            // Retrieve the site configuration via the new Site API
            // Fetch the Pages TSconfig for the given PID.
            if ( ! array_key_exists('plugin' ,  $ts )) {
                return ;
            }
        }

        $configuration = EmConfigurationUtility::getEmConf();
        if( !array_key_exists('allowed' , $configuration)) {
            return ;
        }

        $configuration = GeneralUtility::trimExplode( "," ,$configuration['allowed']);
        if( !is_array($configuration) || count($configuration) == 0 ) {
            return ;
        }
        $result = [] ;
        foreach ( $ts['plugin'] as $extension => $value ) {
            foreach ( $configuration as $allowed ) {
                if ( strpos( $extension , $allowed ) > -1 ) {
                    $result[$extension] = $value ;
                }
            }
        }
         if( $extKey != "all" ) {
               if( array_key_exists($extKey , $result) ) {
                  $result = [$extKey => $result[$extKey]];
               } else {
                  $result = [] ;
               }
         }



        $jsonOutput = json_encode($result);
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: no-cache');
        header('Content-Length: ' . strlen($jsonOutput));
        header('Content-Type: application/json; charset=utf-8');
        header('Content-Transfer-Encoding: 8bit');
        echo $jsonOutput;
        die();
    }
    private static function convertFlatToArray(?array $flat ) {
        if (is_array($flat)) {
            $ts = [];
            foreach ($flat as $key => $value) {
                $keys = explode('.' , $key);
                $temp = &$ts ;
                foreach ($keys as $k) {
                    if (is_array($temp)) {
                        if (!array_key_exists($k, $temp)) {
                            $temp[$k] = [];
                        }
                        $temp = &$temp[$k];
                    }

                }
                $temp = $value ;
            }
            return $ts ;
        }
        return false ;
    }

    /**
     * Removes the dots from an typoscript array
     * @author Peter Benke <pbenke@allplan.com>
     * @param $array
     * @return array
     */
    private static function removeDotsFromTypoScriptArray($array) {

        $newArray = Array();
        if(is_array($array)){
            foreach ($array as $key => $val) {
                if (is_array($val)) {
                    // Remove last character (dot)
                    $newKey = substr($key, 0, -1);
                    $newVal = self::removeDotsFromTypoScriptArray($val);
                } else {
                    $newKey = $key;
                    $newVal = $val;
                }
                $newArray[$newKey] = $newVal;
            }
        }
        return $newArray;
    }

}
