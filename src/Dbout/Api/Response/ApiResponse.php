<?php

namespace Dbout\Api\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiResponse
 * Classe qui permet de renvoyer une reponse Json structuree par une API
 *
 * @package     Dbout\Api\Response;
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2018 Dimitri BOUTEILLE
 */
class ApiResponse extends JsonResponse {

    /**
     * @var string Nom de la clef qui contient le resultat
     */
    const RESPONSE_RESULT = 'results';

    /**
     * @var string Nom de la clef qui contient le status
     */
    const RESPONSE_STATUS = 'status';

    /**
     * @var string Nom de la clef qui contient le code status (404, 200, 201, ...)
     */
    const RESPONSE_STATUS_CODE = 'code';

    /**
     * @var string Nom de la clef qui contient le type du status (ok, ...)
     */
    const RESPONSE_STATUS_TYPE = 'type';

    /**
     * @var string Nom de la clef qui contient le message d'erreur du status
     */
    const RESPONSE_STATUS_ERROR_MESSAGE = 'error_message';

    /**
     * @var array Contient les informations sur le statut
     */
    private $__status = [
        ApiResponse::RESPONSE_STATUS_CODE =>            null,
        ApiResponse::RESPONSE_STATUS_TYPE =>            null,
        ApiResponse::RESPONSE_STATUS_ERROR_MESSAGE =>   null,
    ];

    /**
     * @var array|mixed Contient le resultat de la reponse
     */
    private $__results = [];


    ///
    /// CONSTRUCTOR
    ///

    /**
     * ApiResponse constructor.
     *
     * @param null  $data
     * @param null  $statusType
     * @param int   $statusCode
     * @param array $headers
     * @param bool  $json
     *
     * @throws \Dbout\Api\ApiException
     * @throws \Dbout\Api\Response\ApiException
     */
    public function __construct($data = null, $statusType = null, int $statusCode = 200, array $headers = array(), bool $json = false) {

        parent::__construct($data, $statusCode, $headers, $json);
        $this->setStatusCode($statusCode);

        if(!is_null($statusType)) {
            $this->setStatusType($statusType);
        }
    }


    ///
    /// GETTER
    ///

    /**
     * Function getStatusType
     *
     * @return null|string
     */
    public function getStatusType(): ?string {

        return $this->__status[ApiResponse::RESPONSE_STATUS_TYPE];
    }

    /**
     * Function getStatusMessageError
     *
     * @return null|string
     */
    public function getStatusMessageError(): ?string {

        return $this->__status[ApiResponse::RESPONSE_STATUS_ERROR_MESSAGE];
    }


    ///
    /// SETTER
    ///

    /**
     * Function setStatusType
     *
     * @param string $type
     *
     * @return \Dbout\Api\Response\ApiResponse
     * @throws \Dbout\Api\Response\ApiException
     */
    public function setStatusType(string $type): self {

        if(!in_array($type, ApiResponseType::$status)) {
            throw new ApiException(sprintf('The status type %s is invalid. Types : %s', $type, implode(', ', ApiResponseType::$status)));
        }

        $this->__status[self::RESPONSE_STATUS_TYPE] = $type;
        return $this;
    }

    /**
     * Function setStatusCode
     *
     * @param int  $code
     * @param null $message
     *
     * @return \Dbout\Api\Response\ApiResponse
     */
    public function setStatusCode(int $code, $message = null): self {

        $this->__status[self::RESPONSE_STATUS_CODE] = $code;
        parent::setStatusCode($code, $message);

        if(!is_null($message)) {
            $this->setStatusErrorMessage($message);
        }

        return $this;
    }

    /**
     * Function setStatusErrorMessage
     *
     * @param string $message
     *
     * @return \Dbout\Api\Response\ApiResponse
     */
    public function setStatusErrorMessage(string $message): self {

        $this->__status[ApiResponse::RESPONSE_STATUS_ERROR_MESSAGE] = $message;
        return $this;
    }

    /**
     * Function setResult
     * Initialise le nouveau resultat
     *
     * @param array $data
     *
     * @return \Dbout\Api\Response\ApiResponse
     */
    public function setResult(array $data): self {

        $this->__results = $data;
        return $this;
    }

    /**
     * Function addResult
     * Ajoute des valeurs au resultat deja existant en fusionnant (merge) l'ancien resultat avec le nouveau
     *
     * @param array $data Donnees a ajouter aux donnees deja existantes
     *
     * @return \Dbout\Api\Response\ApiResponse
     */
    public function addResult(array $data): ApiResponse {

        $this->__results = array_merge($this->__results, $data);
        return $this;
    }


    ///
    /// PUBLIC FUNCTIONS
    ///

    /**
     * Function prepare
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|void
     * @throws \Dbout\Api\Response\ApiException
     */
    public function prepare(Request $request) {

        $response = $this->toArray();

        $this->setData($response);
        parent::prepare($request);
    }

    /**
     * Function toArray
     * Permet de recuperer le contenu de la reponse au format tableau
     *
     * @return array
     * @throws \Dbout\Api\Response\ApiException
     */
    public function toArray(): array {

        // Check if response type is valid
        if(is_null($this->getStatusType())) {
            throw new ApiException('The status type can\'t be null.');
        }

        return [
            ApiResponse::RESPONSE_STATUS => $this->__status,
            ApiResponse::RESPONSE_RESULT => $this->__results
        ];
    }

}
