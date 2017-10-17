<?php

namespace Application\Entidade;

/**
 * ParticipantAnswer
 */
class ParticipantAnswer
{
    /**
     * @var string
     */
    private $answer;

    /**
     * @var integer
     */
    private $isCorrect;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Application\Entidade\Participant
     */
    private $participant;

    /**
     * @var \Application\Entidade\Question
     */
    private $question;

    /**
     * @var \Application\Entidade\QuestionOption
     */
    private $questionOption;


    /**
     * Set answer
     *
     * @param string $answer
     *
     * @return ParticipantAnswer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set isCorrect
     *
     * @param integer $isCorrect
     *
     * @return ParticipantAnswer
     */
    public function setIsCorrect($isCorrect)
    {
        $this->isCorrect = $isCorrect;

        return $this;
    }

    /**
     * Get isCorrect
     *
     * @return integer
     */
    public function getIsCorrect()
    {
        return $this->isCorrect;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set participant
     *
     * @param \Application\Entidade\Participant $participant
     *
     * @return ParticipantAnswer
     */
    public function setParticipant(\Application\Entidade\Participant $participant = null)
    {
        $this->participant = $participant;

        return $this;
    }

    /**
     * Get participant
     *
     * @return \Application\Entidade\Participant
     */
    public function getParticipant()
    {
        return $this->participant;
    }

    /**
     * Set question
     *
     * @param \Application\Entidade\Question $question
     *
     * @return ParticipantAnswer
     */
    public function setQuestion(\Application\Entidade\Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \Application\Entidade\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set questionOption
     *
     * @param \Application\Entidade\QuestionOption $questionOption
     *
     * @return ParticipantAnswer
     */
    public function setQuestionOption(\Application\Entidade\QuestionOption $questionOption = null)
    {
        $this->questionOption = $questionOption;

        return $this;
    }

    /**
     * Get questionOption
     *
     * @return \Application\Entidade\QuestionOption
     */
    public function getQuestionOption()
    {
        return $this->questionOption;
    }
}

