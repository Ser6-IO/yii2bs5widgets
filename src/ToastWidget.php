<?php

namespace ser6io\yii2bs5widgets;

use Yii;
use yii\base\Widget; //or \yii\bootstrap5\

/**
 * ToastWidget renders Toast notifications.
 *  - Session flash messages
 *  - Custom toasts
 */
class ToastWidget extends Widget
{
    public $containerOptions = 'position-fixed top-0 start-50 translate-middle-x mt-3';
    public $sessionToasts = true;

    public $toasts = [];

    //public $closeButton = true;
    //public $header;

    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - key: the name of the session flash variable
     * - value: the bootstrap alert type (i.e. danger, success, info, warning)
     */
    public $alertTypes = [
        'error'   => 'bg-danger-subtle',
        'danger'  => 'bg-danger-subtle',
        'success' => 'bg-success-subtle',
        'info'    => 'bg-info-subtle',
        'warning' => 'bg-warning-subtle'
    ];

    public $alertBorderTypes = [
        'error'   => 'border-danger',
        'danger'  => 'border-danger',
        'success' => 'border-success',
        'info'    => 'border-info',
        'warning' => 'border-warning'
    ];

    
    /**
     * @var array the options for rendering the close button tag.
     * Array will be passed to [[\yii\bootstrap\Alert::closeButton]].
     */
    public $closeButton = [];

     /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $this->view->registerJs(
           "var toastElList = [].slice.call(document.querySelectorAll('.toast-alert'))
            var toastList = toastElList.map(function(toastEl) { // Creates an array of toasts (it only initializes them)
                return new bootstrap.Toast(toastEl) // No need for options; use the default options
            });
            toastList.forEach((toast, i) => {
                setTimeout(() => {
                    toast.show()
                }, i * 500);
            }); // Show them ALL, w/ 1/2 delay between each",
            yii\web\View::POS_READY,
            'showToasts'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {         
        echo "<div class='toast-container $this->containerOptions'>";

        if ($this->sessionToasts) {
            foreach (Yii::$app->session->allFlashes as $type => $flash) {
                if (!isset($this->alertTypes[$type])) {
                    continue;
                }
                foreach ((array) $flash as $i => $message) {
                    $this->renderToast($type, $message, null, 'toast-alert');
                }
                Yii::$app->session->removeFlash($type);
            }
        }

        foreach ($this->toasts as $id => $toast) {
            $this->renderToast($toast['type'], $toast['message'], $id);
        }

        echo '</div>';
    }


    private function renderToast($type, $message, $id=null, $sessionToastClass=null)
    {
        if ($id != null) {
            $id = "id='{$id}_toast' ";
        }
        $toast = "<div $id class=' $sessionToastClass border " . $this->alertBorderTypes[$type] . " " . $this->alertTypes[$type] . " toast align-items-center' role='alert' aria-live='assertive' aria-atomic='true'>".
                    "<div class='d-flex'>".
                        "<div class='toast-body'>" . $message . "</div>".
                        "<button type='button' class='btn-close me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>".
                    "</div>".
                "</div> ";
        echo $toast;

        $this->registerJs("$id = new bootstrap.Toast(document.getElementById('{$id}_toast'))");
    }
}

/* 
ToDo: Header
// Toast Header Sample
    <div class="toast-header">
        <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#007aff"></rect></svg>
        <strong class="me-auto">Bootstrap</strong>
        <small class="text-muted">just now</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>   
*/
        
