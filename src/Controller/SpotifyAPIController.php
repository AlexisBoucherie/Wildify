<?php

namespace App\Controller;

use SpotifyWebAPI;

class SpotifyAPIController
{
    private string $clientId;
    private string $clientSecret;

    public function __construct(
        string $clientId = CLIENT_ID,
        string $clientSecret = CLIENT_SECRET
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /* FONCTION DE CONNEXION */

    /**
     * Manage connection to Spotify API
     *
     * A user must be a Spotify user to login and must be added to the list of authorized people before,
     * by Alexis (manager of the App on Spotify)
     *
     * @return void
     */
    public function connectToAPI(): void
    {
        // Processus de connexion sans devoir passer par l'authentification Spotify
        if (!isset($_SESSION['access-token'])) {
            $session = new SpotifyWebAPI\Session(
                $this->getClientId(),
                $this->getClientSecret()
            );

            $session->requestCredentialsToken();
            $accessToken = $session->getAccessToken();

            // On place le token dans notre variable session.
            // Il est possible de le stocker dans une BDD, sinon.
            $_SESSION['access-token'] = $accessToken;
        }
    }

    /* FONCTIONS CRUD - Récupérer les infos des chansons */

    /**
     * Get the info of one track at a time
     *
     * @param string $track
     * @return array|object
     */
    public function getTrackInfo(string $track)
    {
        // On récupère le token dans notre variable session.
        // Il est possible de le stocker dans une BDD, sinon.
        $accessToken = $_SESSION['access-token'];

        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        return $track = $api->getTrack($track);
    }

    /**
     * Get the info of multiple tracks, feeding the function an array of track IDs
     *
     * @param array $tracks
     * @return array|object
     */
    public function getMultipleTracks(array $tracks)
    {
        // On récupère le token dans notre variable session.
        // Il est possible de le stocker dans une BDD, sinon.
        $accessToken = $_SESSION['access-token'];

        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        return $tracks = $api->getTracks($tracks);
    }

    /**
     * Function to artificially inject songs ID to the "get mutiple tracks" function
     * You need first to look for a song on Spotify and get its ID in the URL
     *
     * @return array
     */
    public function createTrackLists(): array
    {
        $metalMusic = [
            '3K4HG9evC7dg3N0R9cYqk4', '61mWefnWQOLf90gepjOCb3', '4PWxt9Fy949kUtkEi2GI5V',
            '3IDOmkdbqgOiMORoyiQtyS', '0tljt9o0lVww8YPGq4S6Vf', '3QOgIKOmAGdcMqeGa3Yl5C',
            '6NwbeybX6TDtXlpXvnUOZC', '76oKOs2o16kqZdVDLYvDgH', '5a3iwxwrtugLi5KEZXLnX1',
            '7LRMbd3LEoV5wZJvXT1Lwb', '2b9lp5A6CqSzwOrBfAFhof', '2JS1iE5A5RHvUPH5Zl9jlF',
            '6FbYLz3QcZb70mKlojSj1m', '2fed1yXI1clOEddfGyKyH2', '0xcF2mC6MktbXOT7kRiXoF'
        ];
        $rockMusic = [
            '25H6P7a94WUr5102lC6TNI', '4gphxUgq0JSFv2BCLhNDiE', '5MxNLUsfh7uzROypsoO5qe',
            '3EYOJ48Et32uATr9ZmLnAo', '6kooDsorCpWVMGc994XjWN', '60VNmTr9ox1PaCIOCprfIa',
            '2Cdvbe2G4hZsnhNMKyGrie', '5ghIJDpPoe3CfHMGu71E6T', '6KTv0Z8BmVqM7DPxbGzpVC',
            '1uKKoa5MABOtsB4xwTwoLY', '5SAUIWdZ04OxYfJFDchC7S', '5CQ30WqJwcep0pYcV4AMNc',
            '2PzU4IB8Dr6mxV3lHuaG34', '7pmNNEJcBcODkrPHEIf7Cy', '2QfiRTz5Yc8DdShCxG1tB2'
        ];
        $popMusic = [
            '4r6eNCsrZnQWJzzvFh4nlg', '0nucG9RsYTuv5Ztm5f4cnu', '70uAATa6l9BHWfAMYFV28u',
            '6ZBJFWDYJSTQg54eDsqnkJ', '7qiZfU4dY1lWllzX7mPBI3', '7Lf7oSEVdzZqTA0kEDSlS5',
            '6I9VzXrHxO9rA9A5euc8Ak', '5R9a4t5t5O0IsznsrKPVro', '3TGRqZ0a2l1LRblBkJoaDx',
            '0lHAMNU8RGiIObScrsRgmP', '6NPVjNh8Jhru9xOmyQigds', '1Je1IMUlBXcx1Fz0WE7oPT',
            '3S2R0EVwBSAVMd5UMgKTL0', '78His8pbKjbDQF7aX5asgv', '60WiEteADDUQKn62YIrlBx'
        ];
        $electroMusic = [
            '1pKYYY0dkg23sQQXi0Q5zN', '4wSmqFg31t6LsQWtzYAJob', '0l2c67gYvWLmYkz8l1gbdn',
            '6VRhkROS2SZHGlp0pxndbJ', '0UAEHlFR79k9CJvknSGUNf', '3u5N55tHf7hXATSQrjBh2q',
            '0molLCkfeNcLxV3oNgGY9a', '2NBk0V7jF1481AqFjXkKKT', '5B03nSG8pLE48jh7kmasuL',
            '1dFkD1JfRMzwO6hwUsE8aS', '5aq8I9nVg1P9ZmcP9xH4Rz', '3PB2m8DG0y9j8EwMSr5MBN',
            '5iSEsR6NKjlC9SrIJkyL3k', '1FpK9rOAdGvalVwsAu68nd', '3Q2NRW22WgA8goEWFf2kL3'
        ];
        $countryMusic = [
            '5rDkA2TFOImbiVenmnE9r4', '3g5k04QYJJgcpwErTwMoaB', '2yrIW9McK27EKnerxlZpVx',
            '6LahUh0U4umx6hDFfVWlGi', '0eZcFq1zvOh6buqrL4VBhP', '2SpEHTbUuebeLkgs9QB7Ue',
            '7cyBw7bpAOYhzyNv7yqW6y', '3TbHnaVih1wgrr3Xa1Cy03', '0VwTeYNjcl30DyQlt3GPe0',
            '2xYQTU2bbg6WVAmpY1eae4', '30m1G9YyiwQzFG7QvAZzHE', '6xatfNMI8NkY5XxRHAeiS4',
            '3giQ7393501IRNrd8iHugf', '5KqldkCunQ2rWxruMEtGh0', '7k1Xm1wy00hCKJDYJL5p1n'
        ];

        shuffle($metalMusic);
        shuffle($rockMusic);
        shuffle($popMusic);
        shuffle($electroMusic);
        shuffle($countryMusic);

        $metalMusic = array_splice($metalMusic, 9);
        $rockMusic = array_splice($rockMusic, 9);
        $popMusic = array_splice($popMusic, 9);
        $electroMusic = array_splice($electroMusic, 9);
        $countryMusic = array_splice($countryMusic, 9);

        return $tracks = [$metalMusic, $rockMusic, $popMusic, $electroMusic, $countryMusic];
    }

    /**
     * Search for a term of a given type
     * (ex. "The Queen", "Artist")
     * (ex. "Rock", "Playlist")
     *
     * @param $search
     * @param $type
     * @return array|object
     */
    public function searchTracks($search, $type): array|object
    {
        // On récupère le token dans notre variable session.
        // Il est possible de le stocker dans une BDD, sinon.
        $accessToken = $_SESSION['access-token'];

        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        return $api->search($search, $type);
    }

    /* GETTERS AND SETTERS */

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }
}
