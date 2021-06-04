<?php
/**
 * @link      https://github.com/e-kevin/engine-core
 * @copyright Copyright (c) 2021 E-Kevin
 * @license   BSD 3-Clause License
 */

use EngineCore\Ec;
use EngineCore\helpers\ArrayHelper;
use yii\bootstrap\Html;
use yii\helpers\ReplaceArrayValue;
use yii\helpers\UnsetArrayValue;


$this->title = 'ArrayHelper::superMerge()使用方法';
?>

    <div class="page-header">
        <h2>\EngineCore\helpers\ArrayHelper::superMerge()</h2>
    </div>

    <p class="lead">
        <span class="text-warning">static</span> superMerge($a, $ab, [...])用法
        <small class="text-muted">数组合并</small>
    </p>

<?php
$usage = [
    [
        'title' => '转换链式键名配置的数组，支持`ReplaceArrayValue()`和`UnsetArrayValue()`对象',
        'items' => [
            [
                'title'       => '',
                'array-1'     => [],
                'array-2'     => [
                    'container' => [
                        'definitions' => [
                            'EngineCore\services\ServiceLocator' => [
                                ':locators.extension.services'                  => [
                                    ':controller.model' => [
                                        'class' => 'EngineCore\\extension\\repository\\models\\Controller',
                                    ],
                                ],
                                ':locators.extension.services.controller.model' => [
                                    'property' => '指定的键名路径不存在，则会按该路径新增数据',
                                ],
                                ':locators.extension.services.replace'          => new ReplaceArrayValue('使用`ReplaceArrayValue()`对象替换'),
                                ':locators.extension.services.delete'           => new UnsetArrayValue(),
                            ],
                        ],
                    ],
                ],
                'array-1-col' => 'col-md-3 col-md-push-9',
                'array-2-col' => 'col-md-9 col-md-pull-3',
                'do'          => 'ArrayHelper::superMerge($array-1, $array-2); // 合并空数组可直接生成转换后的数组',
                'debug'       => [
                    'container' => [
                        'definitions' => [
                            'EngineCore\services\ServiceLocator' => [
                                'locators' => [
                                    'extension' => [
                                        'services' => [
                                            'controller' => [
                                                'model' => [
                                                    'class'    => 'EngineCore\\extension\\repository\\models\\Controller',
                                                    'property' => '指定的键名路径不存在，则会按该路径新增数据',
                                                
                                                ],
                                            ],
                                            'replace'    => '使用`ReplaceArrayValue()`对象替换',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    [
        'title'   => '合并多个数组',
        'array-1' => [
            'container' => [
                'definitions' => [
                    'EngineCore\services\ServiceLocator' => [
                        'locators' => [
                            'extension' => [
                                'services' => [
                                    'controller' => [
                                        'model' => [
                                            'class'    => '这是原有的类',
                                            'property' => '这是原有的属性',
                                        ],
                                    ],
                                    'modularity' => [
                                        'model' => [
                                            'class'    => '这是原有的类',
                                            'property' => '这是原有的属性',
                                        ],
                                    ],
                                    'config'     => [
                                        'model' => [
                                            'class'    => '这是原有的类',
                                            'property' => '这是原有的属性',
                                        ],
                                    ],
                                    'theme'      => [
                                        'model' => [
                                            'class'    => '这是原有的类',
                                            'property' => '这是原有的属性',
                                        ],
                                    ],
                                    'delete'     => '用来测试删除的数据',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'array-2' => [
            ':container.definitions.EngineCore\services\ServiceLocator' => [
                ':locators.extension.services.controller.model.class'      => '只更改`class`的值，其他属性保留',
                ':locators.extension.services'                             => [
                    ':modularity.model.class' => '多维数组下更改`class`的值，其他属性保留',
                ],
                ':locators.extension.services.modularity.model.property-new' => '这是新增加的属性',
                ':locators.extension.services.config'                      => [
                    'model' => [
                        'class'      => '包含`class`键名，则直接替换原来的数组',
                        'property-new' => '原来的属性已经被替换',
                    ],
                ],
                ':locators.extension.services.theme.model'                 => new ReplaceArrayValue([
                    'class' => '使用`ReplaceArrayValue()`对象替换原来的数组',
                ]),
                ':locators.extension.services.delete'                      => new UnsetArrayValue(), // 删除数据
            ],
        ],
        'do'      => 'ArrayHelper::superMerge($array-1, $array-2);',
        'debug'   => [
            'container' => [
                'definitions' => [
                    'EngineCore\services\ServiceLocator' => [
                        'locators' => [
                            'extension' => [
                                'services' => [
                                    'controller' => [
                                        'model' => [
                                            'class'    => '只更改`class`的值，其他属性保留',
                                            'property' => '这是原有的属性',
                                        ],
                                    ],
                                    'modularity' => [
                                        'model' => [
                                            'class'    => '多维数组下更改`class`的值，其他属性保留',
                                            'property' => '这是原有的属性',
                                            'property-new' => '这是新增加的属性',
                                        ],
                                    ],
                                    'config' => [
                                        'model' => [
                                            'class'    => '包含`class`键名，则直接替换原来的数组',
                                            'property-new' => '原来的属性已经被替换',
                                        ],
                                    ],
                                    'theme' => [
                                        'model' => [
                                            'class'    => '使用`ReplaceArrayValue()`对象替换原来的数组',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];

$rowFunc = function ($row) {
    echo '<div class="row">';
    $array1Col = $row['array-1-col'] ?? 'col-md-6';
    $array2Col = $row['array-2-col'] ?? 'col-md-6';
    echo "<div class=\"{$array1Col}\">";
    echo '$array-1：';
    echo "<div class=\"pre-scrollable\" style=\"margin-bottom: 10px;\">";
    Ec::dump($row['array-1']);
    echo '</div>';
    echo '</div>';
    echo "<div class=\"{$array2Col}\">";
    echo '$array-2：';
    echo "<div class=\"pre-scrollable\" style=\"margin-bottom: 10px;\">";
    Ec::dump($row['array-2']);
    echo '</div>';
    echo '</div>';
    echo '</div>';
    
    echo '<div class="row">';
    echo '<div class="col-md-12">';
    echo '执行操作：';
    echo Html::tag('pre', $row['do']);
    $array = ArrayHelper::superMerge($row['array-1'], $row['array-2']);
    echo '</div>';
    echo '</div>';
    
    echo '<div class="row">';
    echo '<div class="col-md-6">';
    echo '返回结果：';
    Ec::dump($array);
    echo '</div>';
    if (!empty($row['debug'])) {
        echo '<div class="col-md-6">';
        echo '调试对比数据：' . ($array === $row['debug']
                ? Html::tag('span', '<b>一致</b>', [
                    'class' => 'text-success',
                ])
                : Html::tag('span', '<b>异常</b>', [
                    'class' => 'text-danger',
                ])
            );
        Ec::dump($row['debug']);
        echo '</div>';
    }
    echo '</div>';
};
foreach ($usage as $row) {
    // panel
    echo '<div class="panel panel-info">';
    // panel-heading
    echo '<div class="panel-heading">';
    echo Html::tag('h3', $row['title'], [
        'class' => 'panel-title',
    ]);
    // panel-heading
    echo '</div>';
    // panel-body
    echo '<div class="panel-body">';
    if (!empty($row['items'])) {
        foreach ($row['items'] as $r) {
            echo Html::tag('p', $r['title'], [
                'class' => 'text-primary',
            ]);
            $rowFunc($r);
            echo '<div style="padding-bottom: 9px;margin: 0 0 20px;border-bottom: 1px solid #eeeeee;"></div>';
        }
    } else {
        $rowFunc($row);
    }
    // panel-body
    echo '</div>';
    // panel
    echo '</div>';
}
//
//
//// 多个链式键名配置处理
//$array = [
//    'container' => [
//        'definitions' => [
//            'EngineCore\services\ServiceLocator' => [
//                'locators' => [
//                    'extension' => [
//                        'services' => [
//                            'controller' => [
//                                'model' => [
//                                    'class'    => '这是原有的类',
//                                    'property' => '这是原有的属性',
//                                ],
//                            ],
//                            'modularity' => [
//                                'model' => [
//                                    'class'    => '这是原有的类',
//                                    'property' => '这是原有的属性',
//                                ],
//                            ],
//                            'config'     => [
//                                'model' => [
//                                    'class'    => '这是原有的类',
//                                    'property' => '这是原有的属性',
//                                ],
//                            ],
//                            'theme'      => [
//                                'model' => [
//                                    'class'    => '这是原有的类',
//                                    'property' => '这是原有的属性',
//                                ],
//                            ],
//                            'delete'     => '用来测试删除的数据',
//                        ],
//                    ],
//                ],
//            ],
//        ],
//    ],
//];
//
//$array1 = [
//    ':container.definitions.EngineCore\services\ServiceLocator' => [
//        // 使用链式键名定位到需要更改的地方，简洁美观
//        ':locators.extension.services.controller.model.class' => '只更改`class`的值，其他属性保留',
//        ':locators.extension.services.controller'             => [
//            'model' => [
//                'class'        => 'fas',
//                'property-new' => '合并操作新增加的属性',
//            ],
//        ],
////        // 支持多维数组定位
////        ':locators.extension.services'                             => [
////            ':modularity.model.class' => '多维数组下更改`class`的值，其他属性保留',
////        ],
////        ':locators.extension.services.modularity.model.property-1' => '这是新增加的属性',
////        ':locators.extension.services.config'                      => [
////            'model' => [
////                'class'      => '包含`class`键名，则直接替换原来的数组',
////                'property-1' => '原来的属性已经被替换',
////            ],
////        ],
////        ':locators.extension.services.theme.model'                 => new ReplaceArrayValue([
////            'class' => '使用`ReplaceArrayValue()`对象替换原来的数组',
////        ]),
////        ':locators.extension.services.delete'                      => new UnsetArrayValue(), // 删除数据
//    ],
//];
//
//Ec::dump(ArrayHelper::superMerge($array, $array1));

?>