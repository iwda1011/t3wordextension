<?php
namespace Aoe\RestlerExamples\Controller\RestApiClientExamples;

use Aoe\RestlerExamples\Domain\Model\Car;
use Aoe\RestlerExamples\Domain\Model\Manufacturer;
use Luracast\Restler\RestException;

class InternalApiController
{
    /**
     * Internal API-Endpoint
     *
     * This internal API-endpoint is protected from outside, if production-mode is active.
     * Use Aoe\Restler\System\RestApi\RestApiClient to call this endpoint.
     *
     * @url GET internal_endpoint/cars/{id}
     * @access protected
     * @class Aoe\RestlerExamples\Controller\RestApiClientExamples\InternalApiAuthenticationController {@checkAuthentication true}
     *
     * @param integer $id
     * @return Car {@type \Aoe\RestlerExamples\Domain\Model\Car}
     */
    public function getCarById($id)
    {
        
        return "yolomän";
        //return $car;
    }
}
