# Symfony Api Response

[![Php version](https://img.shields.io/badge/Symfony-4-red.svg)](https://symfony.com/4)

symfony-api-response est une librairie php qui permet de renvoyer une réponse JSON structurée depuis (utile notamment pour les API comme API Platform). La librairie se base sur la classe `Symfony\Component\HttpFoundation\JsonResponse` de Symfony 4, ainsi les fonctions disponibles dans cette classe, le sont aussi dans la librairie.

La librairie est compatible uniquement avec `Symfony 4`.

### Utilisation simple

    // Reponse retournee par le controller
    $response = new Dbout\Api\Response\ApiResponse();
    return $response->setResult(['data' => 'Hello world']
        ->setStatusType(Dbout\Api\Response\ApiResponseType::OK)
        ->setStatusCode(200);
        
        
### Réponse type

    {
        "status": {
            "code": 200,
            "type": "OK",
            "error_message": null
        },
        "results": {
            "data": "Hello world",
        }
    }
    
### Utilisation avec API Platform

La librairie a été développée pour être utilisé avec `Api Platform`, ainsi l'implémentation d'une ([opération personnalitée](https://api-platform.com/docs/core/operations#creating-custom-operations-and-controllers)) type pourrait être :

    use Dbout\Api\Response\ApiResponse;
    use Dbout\Api\Response\ApiResponseType;

    /**
     * Function __invoke
     *
     * @return \Dbout\Api\Response\ApiResponse
     * @throws \Dbout\Api\Response\ApiException
     */
    public function __invoke(): ApiResponse {
    
        $response = new ApiResponse();
        
        // Do something
        $data = [...]
        
        return $response->setStatusType(ApiResponseType::OK)
            ->setStatusCode(200)
            ->setResult($data);
    }