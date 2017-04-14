<?php
namespace app\helpers;

use yii\httpclient\Client;

class GitHubApi {

    static private $client = null;
    static private $apiUrl = 'https://api.github.com';
    static public $baseRepo = 'yiisoft/yii';

    static private $fieldsConf = array(
        'user' => array(
            'avatar_url',
            'name',
            'company',
            'blog',
            'followers',
            'login',
            'html_url'

        ),
        'repo' => array(
            'full_name',
            'description',
            'watchers_count',
            'forks_count',
            'open_issues_count',
            'homepage',
            'html_url',
            'created_at',
        )
    );

    private static function getClient(){
        if(!self::$client){
            return new Client(['baseUrl' => self::$apiUrl]);
        } else {
            return self::$client;
        }
    }

    public static function getUser($login){
        $client = self::getClient();
        $response = $client->createRequest()
            ->setUrl('users/'.$login)
            ->addHeaders(['User-Agent' => 'Awesome-Octocat-App'])
            ->send();
        $res = '';
        if ($response->isOk) {
            $res['status_ok'] = true;
            $data = $response->getData();
            foreach (self::$fieldsConf['user'] as $value){
                $res[$value] = array_key_exists($value, $data)?$data[$value]:'';
            }
        } else {
            $data = $response->getData();
            $res['status_ok'] = false;
            $res['message'] = $data['message'];
        }

        return $res;
    }

    public static function getRepo($repo){
        $client = self::getClient();
//        var_dump('repos/'.$repo);die;
        $response = $client->createRequest()
            ->setUrl('repos/'.$repo)
            ->addHeaders(['User-Agent' => 'Awesome-Octocat-App'])
            ->send();
        $res = '';
        if ($response->isOk) {
            $res['status_ok'] = true;
            $data = $response->getData();
            foreach (self::$fieldsConf['repo'] as $value){
                $res[$value] = array_key_exists($value, $data)?$data[$value]:'';
            }
        } else {
            $data = $response->getData();
            $res['status_ok'] = false;
            $res['message'] = $data['message'];
        }

        return $res;
    }

    public static function getContributors($repo){
        $client = self::getClient();
//        var_dump('repos/'.$repo);die;
        $response = $client->createRequest()
            ->setUrl('repos/'.$repo.'/contributors')
            ->addHeaders(['User-Agent' => 'Awesome-Octocat-App'])
            ->send();
        $res = '';
//        var_dump($response->getData());die('***');
        if ($response->isOk) {
            $res['status_ok'] = true;
            $data = $response->getData();
//            print_r($data); die;
            $res['contributors'] = null;
            if(count($data) >0 ){

            foreach ($data as $key => $user){
                foreach (self::$fieldsConf['user'] as $value){
                    $res['contributors'][$key][$value] = array_key_exists($value, $user)?$user[$value]:'';
                }
            }
            } else{
                $res['contributors'][] = null;
            }
        } else {
            $data = $response->getData();
            $res['status_ok'] = false;
            $res['message'] = $data['message'];
        }

        return $res;
    }

    /*
     *
     Array ( [status_ok] => 1 [0] => Array ( [avatar_url] => https://avatars0.githubusercontent.com/u/993322?v=3 [name] => [company] => [blog] => [followers] => [login] => qiangxue ) [1] => Array ( [avatar_url] => https://avatars1.githubusercontent.com/u/47294?v=3 [name] => [company] => [blog] => [followers] => [login] => samdark ) [2] => Array ( [avatar_url] => https://avatars3.githubusercontent.com/u/209837?v=3 [name] => [company] => [blog] => [followers] => [login] => mdomba ) [3] => Array ( [avatar_url] => https://avatars3.githubusercontent.com/u/100198?v=3 [name] => [company] => [blog] => [followers] => [login] => resurtm ) [4] => Array ( [avatar_url] => https://avatars3.githubusercontent.com/u/189796?v=3 [name] => [company] => [blog] => [followers] => [login] => cebe ) [5] => Array ( [avatar_url] => https://avatars0.githubusercontent.com/u/1482054?v=3 [name] => [company] => [blog] => [followers] => [login] => klimov-paul ) [6] => Array ( [avatar_url] => https://avatars1.githubusercontent.com/u/1443215?v=3 [name] => [company] => [blog] => [followers] => [login] => DaSourcerer ) [7] => Array ( [avatar_url] => https://avatars2.githubusercontent.com/u/342857?v=3 [name] => [company] => [blog] => [followers] => [login] => softark ) [8] => Array ( [avatar_url] => https://avatars3.githubusercontent.com/u/896494?v=3 [name] => [company] => [blog] => [followers] => [login] => creocoder ) [9] => Array ( [avatar_url] => https://avatars2.githubusercontent.com/u/1086008?v=3 [name] => [company] => [blog] => [followers] => [login] => joujiahe ) [10] => Array ( [avatar_url] => https://avatars1.githubusercontent.com/u/440902?v=3 [name] => [company] => [blog] => [followers] => [login] => kidol ) [11] => Array ( [avatar_url] => https://avatars1.githubusercontent.com/u/1118933?v=3 [name] => [company] => [blog] => [followers] => [login] => Borales ) [12] => Array ( [avatar_url] => https://avatars1.githubusercontent.com/u/363611?v=3 [name] => [company] => [blog] => [followers] => [login] => phpnode ) [13] => Array ( [avatar_url] => https://avatars1.githubusercontent.com/u/728971?v=3 [name] => [company] => [blog] => [followers] => [login] => davidhrbac ) [14] => Array ( [avatar_url] => https://avatars3.githubusercontent.com/u/1178722?v=3 [name] => [company] => [blog] => [followers] => [login] => tom-- ) [15] => Array ( [avatar_url] => https://avatars3.githubusercontent.com/u/730039?v=3 [name] => [company] => [blog] => [followers] => [login] => suralc ) [16] => Array ( [avatar_url] => https://avatars3.githubusercontent.com/u/282343?v=3 [name] => [company] => [blog] => [followers] => [login] => lubosdz ) [17] => Array ( [avatar_url] => https://avatars0.githubusercontent.com/u/438046?v=3 [name] => [company] => [blog] => [followers] => [login] => marcovtwout ) [18] => Array ( [avatar_url] => https://avatars3.githubusercontent.com/u/1434034?v=3 [name] => [company] => [blog] => [followers] => [login] => sebathi ) [19] => Array ( [avatar_url] => https://avatars2.githubusercontent.com/u/1321010?v=3 [name] => [company] => [blog] => [followers] => [login] => Yiivgeny ) [20] => Array ( [avatar_url] => https://avatars2.githubusercontent.com/u/795177?v=3 [name] => [company] => [blog] => [followers] => [login] => nineinchnick ) [21] => Array ( [avatar_url] => https://avatars2.githubusercontent.com/u/802505?v=3 [name] => [company] => [blog] => [followers] => [login] => acorncom ) [22] => Array ( [avatar_url] => https://avatars3.githubusercontent.com/u/665862?v=3 [name] => [company] => [blog] => [followers] => [login] => SonkoDmitry ) [23] => Array ( [avatar_url] => https://avatars2.githubusercontent.com/u/196953?v=3 [name] => [company] => [blog] => [followers] => [login] => lightglitch ) [24] => Array ( [avatar_url] => https://avatars1.githubusercontent.com/u/299550?v=3 [name] => [company] => [blog] => [followers] => [login] => munawer-t ) [25] => Array ( [avatar_url] => https://avatars1.githubusercontent.com/u/387868?v=3 [name] => [company] => [blog] => [followers] => [login] => janisto ) [26] => Array ( [avatar_url] => https://avatars1.githubusercontent.com/u/1505372?v=3 [name] => [company] => [blog] => [followers] => [login] => emanwebdev ) [27] => Array ( [avatar_url] => https://avatars0.githubusercontent.com/u/2072064?v=3 [name] => [company] => [blog] => [followers] => [login] => nsanden ) [28] => Array ( [avatar_url] => https://avatars1.githubusercontent.com/u/752058?v=3 [name] => [company] => [blog] => [followers] => [login] => gregmolnar ) [29] => Array ( [avatar_url] => https://avatars3.githubusercontent.com/u/825204?v=3 [name] => [company] => [blog] => [followers] => [login] => rawtaz ) )

     */


}