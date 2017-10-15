<?php

namespace Application\Entidade;

/**
 * QuestionOption
 */
class QuestionOption {
    /**
     * @var string
     */
    private $answer;

    /**
     * @var integer
     */
    private $isCorrect;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Application\Entidade\Question
     */
    private $question;

    private $question_id;

    /**
     * Set answer
     *
     * @param string $answer
     *
     * @return QuestionOption
     */
    public function setAnswer($answer) {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer() {
        return $this->answer;
    }

    /**
     * Set isCorrect
     *
     * @param integer $isCorrect
     *
     * @return QuestionOption
     */
    public function setIsCorrect($isCorrect) {
        $this->isCorrect = $isCorrect;

        return $this;
    }

    /**
     * Get isCorrect
     *
     * @return integer
     */
    public function getIsCorrect() {
        return $this->isCorrect;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Quiz
     */
    public function setCreatedAt($createdAt)
    {

        if ( !empty($createdAt) )
        {
            $dt_data = str_replace('/', '-', $createdAt);

            $this->$createdAt = new \DateTime(date('Y-m-d H:i:s', strtotime($dt_data)));
        }

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        if ($this->createdAt instanceof \DateTime)
        {
            return $this->createdAt->format('d/m/Y H:i:s');
        }
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Quiz
     */
    public function setUpdatedAt($updatedAt)
    {
        if ( !empty($updatedAt) )
        {
            $dt_data = str_replace('/', '-', $updatedAt);

            $this->$updatedAt = new \DateTime(date('Y-m-d', strtotime($dt_data)));
        }

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        if ($this->updatedAt instanceof \DateTime)
        {
            return $this->updatedAt->format('d/m/Y H:i:s');
        }
        return $this->updatedAt;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set question
     *
     * @param \Application\Entidade\Question $question
     *
     * @return QuestionOption
     */
    public function setQuestion(\Application\Entidade\Question $question = null) {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \Application\Entidade\Question
     */
    public function getQuestion() {
        return $this->question;
    }

    /**
     * @return mixed
     */
    public function getQuestionId() {
        return $this->question_id;
    }

    /**
     * @param mixed $question_id
     *
     * @return self
     */
    public function setQuestionId($question_id) {
        $this->question_id = $question_id;

        return $this;
    }

    /**
     * Retorna o toArray
     */
    public function toArray() {
        return array(
            'id' => $this->getId(),
            'answer' => $this->getAnswer(),
            'is_correct' => $this->getIsCorrect(),
            'create_at' => $this->getCreatedAt(),
            'update_at' => $this->getUpdatedAt(),
            'question_id' => $this->getQuestionId(),
        );
    }
}
