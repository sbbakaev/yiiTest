<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\RepoLikeStatus;


class Repo extends Model
{
    public $repoId;
    public $fullName;
    public $name;
    public $description;
    public $watchersCount;
    public $forksCount;
    public $openIssuesCount;
    public $homepage;
    public $htmlUrl;
    public $createdAt;
    public $owner;
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
    public function getRepoId()
    {
        return $this->repoId;
    }

    /**
     * @param mixed $repoId
     */
    public function setRepoId($id)
    {
        $this->repoId = $id;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param mixed $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getWatchersCount()
    {
        return $this->watchersCount;
    }

    /**
     * @param mixed $watchersCount
     */
    public function setWatchersCount($watchersCount)
    {
        $this->watchersCount = $watchersCount;
    }

    /**
     * @return mixed
     */
    public function getForksCount()
    {
        return $this->forksCount;
    }

    /**
     * @param mixed $forksCount
     */
    public function setForksCount($forksCount)
    {
        $this->forksCount = $forksCount;
    }

    /**
     * @return mixed
     */
    public function getOpenIssuesCount()
    {
        return $this->openIssuesCount;
    }

    /**
     * @param mixed $openIssuesCount
     */
    public function setOpenIssuesCount($openIssuesCount)
    {
        $this->openIssuesCount = $openIssuesCount;
    }

    /**
     * @return mixed
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * @param mixed $homepage
     */
    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;
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
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getLikeStatus()
    {
        if ($this->likeStatus !== null) {
            return $this->likeStatus;
        } else {
            return $this->getLikeById($this->repoId);
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

    private function getLikeById($id)
    {
        if (!empty($id)) {
            $model = RepoLikeStatus::find()->where(['repo_id' => $id])->one();
            if ($model) {
                return $model->status;
            } else {
                return false;
            }
        }
        return false;
    }
}
