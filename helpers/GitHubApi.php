<?php
namespace app\helpers;

use app\models\Owner;
use app\models\Repo;
use yii\httpclient\Client;

class GitHubApi
{

    static public $baseRepo = 'yiisoft/yii';
    static private $client = null;
    static private $apiUrl = 'https://api.github.com';
    static private $fieldsConf = array(
        'user' => array(
            'avatar_url',
            'name',
            'company',
            'blog',
            'followers',
            'login',
            'html_url',
        ),
        'repo' => array(
            'id',
            'full_name',
            'name',
            'description',
            'watchers_count',
            'forks_count',
            'open_issues_count',
            'homepage',
            'html_url',
            'created_at',
            'owner',
        )
    );

    /**
     * Return user data
     *
     * @param $login string GitHub user login
     *
     * @return array
     */
    public static function getUser($login)
    {
        $client   = self::getClient();
        $response = $client->createRequest()
            ->setUrl('users/' . $login)
            ->addHeaders(['User-Agent' => 'Awesome-Octocat-App'])
            ->send();
        $res = '';
        if ($response->isOk) {
            $data = $response->getData();
            $res['status_ok'] = true;
            $res['data'] = self::fillUserModel($data);
        } else {
            $data = $response->getData();
            $res['status_ok'] = false;
            $res['message'] = $data['message'];
            $res['data'] = null;
        }

        return $res;
    }

    /**
     * @return null|Client
     */
    private static function getClient()
    {
        if (!self::$client) {
            return new Client(['baseUrl' => self::$apiUrl]);
        } else {
            return self::$client;
        }
    }

    /**
     * Return repo detail or error message
     * @param $repo string GitHub repo full name
     * @return array
     */
    public static function getRepo($repo)
    {
        $client = self::getClient();
        $response = $client->createRequest()
            ->setUrl('repos/' . $repo)
            ->addHeaders(['User-Agent' => 'Awesome-Octocat-App'])
            ->send();
        $res = '';
        if ($response->isOk) {
            $res['status_ok'] = true;
            $data = $response->getData();
            $model = self::fillRepoModel($data);
            $owner = null;
            if (array_key_exists('owner', $data) && !empty($data['owner'])){
                $owner = self::fillUserModel($data['owner']);
            }
            $model->setOwner($owner);
            $res['data'] = $model;
        } else {
            $data = $response->getData();
            $res['status_ok'] = false;
            $res['message'] = $data['message'];
            $res['data'] = null;
        }
        return $res;
    }

    /**
     * Return list contributors of repo
     * @param $repo string GitHub repo full name
     * @return array
     */
    public static function getContributors($repo)
    {
        $client = self::getClient();
        $response = $client->createRequest()
            ->setUrl('repos/' . $repo . '/contributors?page=1&per_page=6')
            ->addHeaders(['User-Agent' => 'Awesome-Octocat-App'])
            ->send();
        $res = '';
        if ($response->isOk) {
            $res['status_ok'] = true;
            $data = $response->getData();
            $res['contributors'] = null;
            if (count($data) > 0) {
                foreach ($data as $key => $user) {
                    $model = self::fillUserModel($user);
                    $res['contributors'][$key] = $model;
                }
            } else {
                $res['contributors'][] = null;
                $res['message'] = 'Has not contributors';
            }
        } else {
            $data = $response->getData();
            $res['status_ok'] = false;
            $res['message'] = $data['message'];
        }

        return $res;
    }

    /**
     * Return owner class which filled data from param
     * @param $data
     * @return Owner
     */
    private static function fillUserModel($data)
    {
        $model = new Owner();
        $model->setLogin(self::checkValue($data, 'login'));
        $model->setName(self::checkValue($data, 'name'));
        $model->setAvataUrl(self::checkValue($data, 'avatar_url'));
        $model->setCompany(self::checkValue($data, 'company'));
        $model->setBlog(self::checkValue($data, 'blog'));
        $model->setFollowers(self::checkValue($data, 'followers'));
        $model->setHtmlUrl(self::checkValue($data, 'html_url'));
        $model->setBlog(self::checkValue($data, 'blog'));

        return $model;

    }

    private static function fillRepoModel($data)
    {
        $model = new Repo();
        $model->setRepoId(self::checkValue($data, 'id'));
        $model->setFullName(self::checkValue($data, 'full_name'));
        $model->setName(self::checkValue($data, 'name'));
        $model->setDescription(self::checkValue($data, 'description'));
        $model->setWatchersCount(self::checkValue($data, 'watchers_count'));
        $model->setForksCount(self::checkValue($data, 'forks_count'));
        $model->setOpenIssuesCount(self::checkValue($data, 'open_issues_count'));
        $model->setHomepage(self::checkValue($data, 'homepage'));
        $model->setHtmlUrl(self::checkValue($data, 'html_url'));
        $model->setCreatedAt(self::checkValue($data, 'created_at'));
        $model->setOwner(self::checkValue($data, 'owner'));

        return $model;

    }

    /**
     * @param $data
     * @param $key
     * @return string
     */
    private static function checkValue($data, $key)
    {
        return array_key_exists($key, $data) ? $data[$key] : '';

    }

    public static function findRepo($query, $page)
    {
        $client = self::getClient();
        $response = $client->createRequest()
            ->setUrl('search/repositories')
            ->setData([
                'q'        => $query,
                'page'     => $page,
                'per_page' => 20,
                'sort'     => 'stars',
                'order'    => 'desc'
            ])
            ->addHeaders(['User-Agent' => 'Awesome-Octocat-App'])
            ->send();
        $res['query'] = $query;
        if ($response->isOk) {
            $res['status_ok'] = true;
            $data = $response->getData();
            if (count($data) > 0) {
                $res['total_count'] = $data['total_count'];
                foreach ($data['items'] as $key => $repo) {
                    $model = self::fillRepoModel($repo);
                    $owner = null;
                    if (array_key_exists('owner', $repo) && !empty($repo['owner'])){
                        $owner = self::fillUserModel($repo['owner']);
                    }
                    $model->setOwner($owner);
                    $res['repos'][$key] = $model;
                }
            } else {
                $res['repos'][] = null;
            }

        } else {
            $data = $response->getData();
            $res['status_ok'] = false;
            $res['message'] = $data['message'];
        }

        return $res;
    }
}