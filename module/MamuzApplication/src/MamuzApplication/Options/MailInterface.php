<?php

namespace MamuzApplication\Options;

interface MailInterface
{
    /**
     * @return string
     */
    public function getBodyTemplate();

    /**
     * @return string
     */
    public function getFrom();

    /**
     * @return string
     */
    public function getSubjectTemplate();

    /**
     * @return string
     */
    public function getTo();
}
