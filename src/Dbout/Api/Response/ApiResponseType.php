<?php

namespace Dbout\Api\Response;

/**
 * Class ApiResponseType
 * Contient les types de reponse possible par l'API
 *
 * @package     Dbout\Api\Response;
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2018 Dimitri BOUTEILLE
 */
class ApiResponseType {

    /**
     * @var string Type de reponse lorsqu'une clef est manquante dans la requete
     */
    const INVALID_REQUEST = 'INVALID_REQUEST';

    /**
     * @var string Type de reponse lorsque la requete c'est bien derouleee
     */
    const OK = 'OK';

    /**
     * @var string Type de response lorsqu'une valeur est invalide dans la requete (par exemple une adresse email pas valide)
     */
    const INVALID_DATA = 'INVALID_DATA';

    /**
     * @var string Type de response lorsque la ressource n'a pas ete trouvee
     */
    const NOT_FOUND = 'NOT_FOUND';

    /**
     * @var array Liste des choix possibles
     */
    public static $status = [
        self::INVALID_REQUEST,
        self::OK,
        self::INVALID_DATA,
        self::NOT_FOUND,
    ];

}
