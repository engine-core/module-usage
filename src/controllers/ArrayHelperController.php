<?php
/**
 * @link      https://github.com/engine-core/module-usage
 * @copyright Copyright (c) 2021 E-Kevin
 * @license   BSD 3-Clause License
 */

declare(strict_types=1);

namespace EngineCore\modules\usage\controllers;

use EngineCore\web\Controller;

/**
 * Class ArrayHelperController
 *
 * @property \EngineCore\modules\usage\Module $module
 *
 * @author E-Kevin <e-kevin@qq.com>
 */
class ArrayHelperController extends Controller
{
    
    public $defaultAction = 'setValue';
    
    protected $defaultDispatchMap = [
        'setValue'   => [
            'map' => 'array-helper-method',
        ],
        'superMerge' => [
            'map' => 'array-helper-method',
        ],
    ];
    
}