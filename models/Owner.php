<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\UserLikeStatus;


class Owner extends Model
{
    public $login;
    public $name;
    public $avataUrl;
    public $company;
    public $blog;
    public $followers;
    public $htmlUrl;
    public $likeStatus = null;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // rememberMe must be a boolean value
            ['likeStatus', 'boolean'],
        ];
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAvataUrl()
    {
        return $this->avataUrl;
    }

    /**
     * @param mixed $avataUrl
     */
    public function setAvataUrl($avataUrl)
    {
        $this->avataUrl = $avataUrl;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return mixed
     */
    public function getBlog()
    {
        return $this->blog;
    }

    /**
     * @param mixed $blog
     */
    public function setBlog($blog)
    {
        $this->blog = $blog;
    }

    /**
     * @return mixed
     */
    public function getFollowers()
    {
        return $this->followers;
    }

    /**
     * @param mixed $followers
     */
    public function setFollowers($followers)
    {
        $this->followers = $followers;
    }

    /**
     * @return mixed
     */
    public function getHtmlUrl()
    {
        return $this->htmlUrl;
    }

    /**
     * @param mixed $htmlUrl
     */
    public function setHtmlUrl($htmlUrl)
    {
        $this->htmlUrl = $htmlUrl;
    }

    /**
     * @return mixed
     */
    public function getLikeStatus()
    {
        if ($this->likeStatus !== null) {
            return $this->likeStatus;
        } else {
            return $this->getLikeByLogin($this->login);
        }
    }

    /**
     * @return mixed
     */
    public function getStatusText()
    {
        if ($this->getLikeStatus()) {
            return 'Unlike';
        } else {
            return 'Like';
        }
    }


    /**
     * @param mixed $like
     */
    public function setLikeStatus($like)
    {
        $this->likeStatus = $like;
    }

    private function getLikeByLogin($login)
    {
        if (!empty($login)) {
            $model = UserLikeStatus::find()->where(['login' => $login])->one();
            if ($model) {
                return $model->status;
            } else {
                return false;
            }
        }
        return false;
    }

}
