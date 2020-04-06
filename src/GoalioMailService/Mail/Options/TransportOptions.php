<?php

namespace GoalioMailService\Mail\Options;

use Laminas\Stdlib\AbstractOptions;

class TransportOptions extends AbstractOptions {

    /** @var string  */
    protected $transportClass = 'Laminas\Mail\Transport\File';

    /** @var string  */
    protected $optionsClass = 'Laminas\Mail\Transport\FileOptions';

    /** @var array  */
    protected $transportOptions = array(
        'path' => 'data/mail/',
    );

    /**
     * @param array $transportOptions
     *
     * @return $this
     */
    public function setTransportOptions($transportOptions) {
        $this->transportOptions = $transportOptions;

        return $this;
    }

    /**
     * @return array
     */
    public function getTransportOptions() {
        return $this->transportOptions;
    }

    /**
     * @param string $optionsClass
     *
     * @return $this
     */
    public function setOptionsClass($optionsClass) {
        $this->optionsClass = $optionsClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getOptionsClass() {
        return $this->optionsClass;
    }

    /**
     * @param string $transportClass
     *
     * @return $this
     */
    public function setTransportClass($transportClass) {
        $this->transportClass = $transportClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransportClass() {
        return $this->transportClass;
    }

}