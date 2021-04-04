<?php

namespace taguz91\ErrorHandler;

use taguz91\ErrorHandler\exceptions\MessageException;
use taguz91\ErrorHandler\utils\Handler;
use yii\web\ErrorHandler as WebErrorHandler;

/**
 * 
 */
class ErrorHandler extends WebErrorHandler
{

  /** @var \taguz91\ErrorHandler\utils\Handler */
  public $handler;

  /** @var string */
  public $empresa;

  /** @var string[] Classname for exception to not save */
  public $exceptionsNotSave = [
    MessageException::class,
  ];

  /** @var bool */
  public $saveError = false;

  public function init()
  {
    parent::init();
    if ($this->handler === null) {
      $this->handler = new Handler($this->exception, $this->empresa);
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function convertExceptionToArray($exception)
  {
    $saveError = $this->saveError;
    if (in_array(get_class($exception), $this->exceptionsNotSave)) {
      $saveError = false;
    }

    return $this->handler->get($saveError);
  }
}
