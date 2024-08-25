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
 * Class Ajax
 * @package JVelletti\JvEvents\Middleware
 */
class Typoscript implements MiddlewareInterface
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

    private function getTypoScript($request , $extension)
    {
        var_dump($extension);
        $configuration = EmConfigurationUtility::getEmConf();
        var_dump($configuration);
        die;

        $singlePid = ( array_key_exists( 'DetailPid' , $configuration) && $configuration['DetailPid'] > 0 ) ? intval($configuration['DetailPid']) : 111 ;
        $output['DetailPid'] = $singlePid  ;
        try {
            $site = GeneralUtility::makeInstance(SiteFinder::class)->getSiteByPageId($singlePid);

        } catch( \Exception $e) {
            // ignore
            $site = false ;
        }
        return;
    }



}
