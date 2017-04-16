<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UserLikeStatus;
use app\helpers\GitHubApi;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionRepo()
    {
        $repoName = Yii::$app->request->get('id');
        if (is_null($repoName)) {
            $repos = GitHubApi::getRepo(GitHubApi::$baseRepo);
            $contributors = GitHubApi::getContributors('yiisoft/yii');
        } else {
            $repos = GitHubApi::getRepo($repoName);
            $contributors = GitHubApi::getContributors($repoName);
        }
        return $this->render('index', [
            'repos' => $repos,
            'contributors' => $contributors
        ]);
    }

    /**
     * Displays search result page.
     *
     * @return string
     */
    public function actionSearch()
    {
        $currentPage = Yii::$app->request->get('page') ? Yii::$app->request->get('page') : 1;
        $query       = Yii::$app->request->get('search');

        $repos = GitHubApi::findRepo($query, $currentPage);
        $pages = new Pagination(['totalCount' => $repos['total_count'], 'pageSize' => 20]);
        $pages->pageSizeParam = false;

        return $this->render('search', [
            'repos' => $repos,
            'pages' => $pages,
        ]);
    }

    /**
     * Displays user detail page.
     *
     * @return string
     */
    public function actionUser()
    {
        $userId = Yii::$app->request->get('id');
        $res = GitHubApi::getUser($userId);

        return $this->render('user', [
            'repo' => $res,
        ]);
    }

    /**
     * ajax change status.
     *
     * @return string
     */
    public function actionChangeUserStatus()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $login = $data['login'];
            $model = UserLikeStatus::find()->where(['login' => $login])->one();
            if ($model) {
                $model->status = $model->status ? 0 : 1;
            } else {
                $model = new UserLikeStatus();
                $model->login = $login;
                $model->status = true;
            }

            $model->save();

            $text = $model->status ? 'Unlike' : 'Like';
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            $response->data = ['label' => $text];
            $response->statusCode = 200;

            return $response;
        } else throw new \yii\web\BadRequestHttpException;
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
