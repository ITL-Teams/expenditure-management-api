<?php
namespace App\Infraestructure\Controller\EnterpriseAccountVerifier;

use Rareloop\Router\RouteParams;
use App\Infraestructure\Controller\Controller;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Database\AccountMySqlRepository;

class EnterpriseAccountVerifierController implements Controller {

  public function handler(RouteParams $params): ControllerResponse {
    $response = new EnterpriseAccountVerifierControllerResponse($params);
    $response->init(new AccountMySqlRepository());
    return $response;
  }

}
