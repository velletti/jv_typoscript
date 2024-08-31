<?php

namespace JVelletti\JvTyposcript\Middleware;

use JVelletti\JvTyposcript\Utility\EmConfigurationUtility;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Http\Stream;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
            $this->getTypoScript($request , $_gp['tx_jvtyposcript']) ;
        }

        return $handler->handle($request);
    }

    private function getTypoScript($request , $extKey)
    {
        $ts = $request->getAttribute('frontend.typoscript')->getSetupArray();
        if ( ! array_key_exists('plugin.' ,  $ts )) {
            echo "LINE: " .  __LINE__  ;
            die() ;
            return ;
        }

        if( $extKey == "all") {
            $ts = self::removeDotsFromTypoScriptArray($ts['plugin.']);
        } else {
            if ( ! array_key_exists($extKey . '.' ,  $ts['plugin.'] )) {
                return ;
            }
            $ts = self::removeDotsFromTypoScriptArray($ts['plugin.'][$extKey . '.']);
        }
        $configuration = EmConfigurationUtility::getEmConf();
        if( !array_key_exists('allowed' , $configuration)) {
            return ;
        }
        $configuration = GeneralUtility::trimExplode( "," ,$configuration['allowed']);
        $result =[] ;
        if ( is_array($configuration) && count($configuration) > 0 ) {
            foreach ( $ts as $extension => $value ) {
                foreach ( $configuration as $allowed ) {
                    if ( strpos( $extension , $allowed ) > -1 ) {
                        $result[$extension] = $value ;
                    }
                }
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
