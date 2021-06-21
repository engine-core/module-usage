<?php
/**
 * @link https://github.com/engine-core/module-usage
 * @copyright Copyright (c) 2021 engine-core
 * @license BSD 3-Clause License
 */

declare(strict_types=1);

namespace EngineCore\modules\usage\dispatches\Basic\ArrayHelper;

use EngineCore\dispatch\Dispatch;

/**
 * Class ArrayHelperMethod
 *
 * @property \EngineCore\modules\usage\controllers\ArrayHelperController $controller
 *
 * @author E-Kevin <e-kevin@qq.com>
 */
class ArrayHelperMethod extends Dispatch
{
    
    public function run()
    {
        return $this->response->render();
    }
    
}