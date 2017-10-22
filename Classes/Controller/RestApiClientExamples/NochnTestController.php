<?php
namespace Aoe\RestlerExamples\Controller\RestApiClientExamples;

use Aoe\RestlerExamples\Domain\Model\Dokument;
use Aoe\RestlerExamples\Domain\Model\Manufacturer;
use Luracast\Restler\RestException;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class NochnTestController
{
    /**
     * Internal API-Endpoint
     *
     * This internal API-endpoint is protected from outside, if production-mode is active.
     * Use Aoe\Restler\System\RestApi\RestApiClient to call this endpoint.
     *
     * @url GET viddel/cars/{id}/{ueberschrift}
     * @access protected
     * @class Aoe\RestlerExamples\Controller\RestApiClientExamples\InternalApiAuthenticationController {@checkAuthentication true}
     *
     * @return Car {@type \Aoe\RestlerExamples\Domain\Model\Car}
     */
    public function getCarById($id, $ueberschrift)
    {
      

        //Neue Seite erstellen die hidden=disabled ist
        $GLOBALS['TYPO3_DB']->exec_INSERTquery('pages', array('title' => $id, 'hidden' => '1'));
   

        //Test-Abfrage
        //$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid', 'pages', 'title="Hier"','','','');
       
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid', 'pages', 'title="'.$id.'"','','','');
        
        



        
        $row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
        $data = $row;
        




        //Neuen Middle-Content mit Überschrift aus NodeJS Frontend
        
        $GLOBALS['TYPO3_DB']->exec_INSERTquery('tt_content', array(
            'pid' => (int)$data['uid'],
            'header' => $ueberschrift,
            'CType' => 'header'
             ));
     

     return  (int)$data['uid'];
        //return  array_values($data);
    }


/**
     * Internal API-Endpoint
     *
     * This internal API-endpoint is protected from outside, if production-mode is active.
     * Use Aoe\Restler\System\RestApi\RestApiClient to call this endpoint.
     *
     * @url GET viddel/cars/1
     * @access protected
     * @class Aoe\RestlerExamples\Controller\RestApiClientExamples\InternalApiAuthenticationController {@checkAuthentication true}
     *
     * @return Car {@type \Aoe\RestlerExamples\Domain\Model\Car}
     */
    public function getAllArticle()
    {
      

        $yolo=[];

        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'pages', 'deleted=0','','','');

        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
            array_push($yolo, $row);
        }

        return $yolo;
        
    }




    /**
    * @url POST dokument
    * @status 201
    *
    * @param Dokument $dokument {@type \Aoe\RestlerExamples\Domain\Model\Dokument}
    * @return Dokument {@type \Aoe\RestlerExamples\Domain\Model\Dokument}
    * @throws RestExeption 400 Dokument is not valid
    */
    public function buyCar(Dokument $dokument)
    {
        
        $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1; //Turn on Debug-mode
        

        $GLOBALS['TYPO3_DB']->exec_INSERTquery('pages', array('title' => $dokument->content[0][title], 'pid' => $dokument->content[0][kategorieid] ,'hidden' => '1', 'description' => $dokument->content[0][description],'abstract' => $dokument->content[0][teaser]));

        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid', 'pages', 'title="'.$dokument->content[0][title].'" AND deleted=0','','','');

        $row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
        $data = $row;
        
        for ($i = 1; $i < count($dokument->content); $i++){

            $GLOBALS['TYPO3_DB']->exec_INSERTquery('tt_content', array(
                'pid' => (int)$data['uid'],
                'header' => $dokument->content[$i][h1],
                'CType' => 'header'
             ));  

            $GLOBALS['TYPO3_DB']->exec_INSERTquery('tt_content', array(
                'pid' => (int)$data['uid'],
                'CType' => 'list',
                'list_type' => $dokument->content[$i][toc]

             ));
            
            $GLOBALS['TYPO3_DB']->exec_INSERTquery('tt_content', array(
                'pid' => (int)$data['uid'],
                'bodytext' => $dokument->content[$i][table],
                'header' => $dokument->content[$i][nein],
                'table_delimiter' => 124,
                'CType' => 'table'
             ));

            $GLOBALS['TYPO3_DB']->exec_INSERTquery('tt_content', array(
                'pid' => (int)$data['uid'],
                'bodytext' => $dokument->content[$i][p],
                'header' => $dokument->content[$i][not],
                'CType' => 'textmedia'
             ));

             $GLOBALS['TYPO3_DB']->exec_INSERTquery('tt_content', array(
                'pid' => (int)$data['uid'],
                'bodytext' => $dokument->content[$i][htmlbody],
                'header' => $dokument->content[$i][noheaderhtml],
                'CType' => 'html'
             ));

            $GLOBALS['TYPO3_DB']->exec_INSERTquery('tt_content', array(
                'pid' => (int)$data['uid'],
                'bodytext' => $dokument->content[$i][p],
                'header' => $dokument->content[$i][h2],
                'CType' => 'textmedia'
             ));

             $GLOBALS['TYPO3_DB']->exec_INSERTquery('tt_content', array(
                'pid' => (int)$data['uid'],
                'bodytext' => $dokument->content[$i][p],
                'header' => $dokument->content[$i][h3],
                'CType' => 'textmedia'
             ));

             $GLOBALS['TYPO3_DB']->exec_INSERTquery('tt_content', array(
                'pid' => (int)$data['uid'],
                'bodytext' => $dokument->content[$i][p],
                'header' => $dokument->content[$i][h4],
                'CType' => 'textmedia'
             ));
        }

        return $dokument;
    }
}
