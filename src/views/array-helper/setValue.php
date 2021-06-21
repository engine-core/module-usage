<?php
/**
 * @link https://github.com/engine-core/module-usage
 * @copyright Copyright (c) 2021 engine-core
 * @license BSD 3-Clause License
 */

use EngineCore\Ec;
use EngineCore\helpers\ArrayHelper;
use yii\bootstrap\Html;
use yii\helpers\ReplaceArrayValue;
use yii\helpers\UnsetArrayValue;

$this->title = 'ArrayHelper::setValue()使用方法';
?>

    <div class="page-header">
        <h2>\EngineCore\helpers\ArrayHelper::setValue()</h2>
    </div>

    <p class="lead">
        <span class="text-warning">static</span> setValue(&$array, $path, $value, $recursive = false)用法
        <small class="text-muted">主要是为$array数组里的$path路径设置指定值</small>
    </p>

    <div class="well text-muted">
        参数说明：
        <ol>
            <li><span class="text-success">$array</span> <span class="text-warning">array</span> 待操作的数组</li>
            <li><span class="text-success">$path</span> <span class="text-warning">string|array|null</span> 键名路径</li>
            <li><span class="text-success">$value</span> <span class="text-warning">mixed</span> 准备写入的数据</li>
            <li><span class="text-success">$recursive</span> <span class="text-warning">boolean</span> 是否启用递归模式</li>
        </ol>
        <p>链式键名配置格式：:key1.key2.key3，这种以<kbd>:</kbd>开始，<kbd>.</kbd>分隔多个键名的字符串。</p>
        <p>删除操作对象：<span class="text-muted">yii\helpers\UnsetArrayValue</span></p>
        <p>替换操作对象：<span class="text-muted">yii\helpers\ReplaceArrayValue</span></p>
    </div>

<?php
$usage = [
    [
        'title' => '使用方法',
        'items' => [
            [
                'title' => '默认情况下，指定的键名路径会直接被`$value`值替换或充填新增',
                'array' => [
                    'level-1' => [
                        'level-2' => [
                            'replace' => '这是用来测试被替换的',
                            'other'   => '其他神一样的存在',
                        ],
                    ],
                ],
                'do'    => <<<php
ArrayHelper::setValue(
    \$array,
    'level-1.level-2.replace', // 键名路径
    '只替换指定键名路径下的数组值'
);
php
                ,
                'path'  => 'level-1.level-2.replace',
                'value' => '只替换指定键名路径下的数组值',
                'debug' => [
                    'level-1' => [
                        'level-2' => [
                            'replace' => '只替换指定键名路径下的数组值',
                            'other'   => '其他神一样的存在',
                        ],
                    ],
                ],
            ],
            [
                'title' => '使用`ReplaceArrayValue()`对象替换',
                'array' => [
                    'level-1' => [
                        'level-2' => [
                            'replace' => '这是用来测试被替换的',
                            'other'   => '其他神一样的存在',
                        ],
                    ],
                ],
                'do'    => <<<php
ArrayHelper::setValue(
    \$array,
    'level-1.level-2.replace', // 键名路径
    new ReplaceArrayValue('使用`ReplaceArrayValue()`对象替换')
);
php
                ,
                'path'  => 'level-1.level-2.replace',
                'value' => new ReplaceArrayValue('使用`ReplaceArrayValue()`对象替换'),
                'debug' => [
                    'level-1' => [
                        'level-2' => [
                            'replace' => '使用`ReplaceArrayValue()`对象替换',
                            'other'   => '其他神一样的存在',
                        ],
                    ],
                ],
            ],
            [
                'title' => '如果键名路径只是一个片段，片段后的数据都会被替换',
                'array' => [
                    'level-1' => [
                        'level-2' => [
                            'level-3' => [
                                'level-4' => [
                                    'tips' => '键名路径只获取到`level-3`，则`level-3`后的数据都会被替换',
                                ],
                            ],
                        ],
                    ],
                ],
                'do'    => <<<php
ArrayHelper::setValue(
    \$array,
    'level-1.level-2.level-3', // 键名路径只获取到`level-3`
    '`level-3`后的数据都已经消失'
);
php
                ,
                'path'  => 'level-1.level-2.level-3',
                'value' => '`level-3`后的数据都已经消失',
                'debug' => [
                    'level-1' => [
                        'level-2' => [
                            'level-3' => '`level-3`后的数据都已经消失',
                        ],
                    ],
                ],
            ],
            [
                'title' => '如果指定的键名路径不存在，则会按该路径新增数据',
                'array' => [
                    'level-1' => [
                        'level-2' => [
                        ],
                    ],
                ],
                'do'    => <<<php
ArrayHelper::setValue(
    \$array,
    'level-1.level-2.property-new',
    '我是新增的数据'
);
php
                ,
                'path'  => 'level-1.level-2.property-new',
                'value' => '我是新增的数据',
                'debug' => [
                    'level-1' => [
                        'level-2' => [
                            'property-new' => '我是新增的数据',
                        ],
                    ],
                ],
            ],
        ],
    ],
    [
        'title' => '启用递归模式，实现多维数组的合并',
        'items' => [
            [
                'title'     => '开启递归模式，实现多维数组的合并而非替换',
                'array'     => [
                    'level-1' => [
                        'level-2' => [
                            'level-3' => [
                                'level-4' => [
                                    'other' => '其他神一样的存在',
                                    'tips'  => '开启递归模式后，只会替换指定路径下的键名值，其他属性均被保留',
                                ],
                            ],
                        ],
                    ],
                ],
                'do'        => <<<php
ArrayHelper::setValue(
    \$array,
    'level-1', // 键名路径只获取到`level-1`，但开启递归模式后，后续的数据不会被替换，而是合并
    [
        'level-2' => [
            ':level-3.level-4' => [ // 链式键名配置方式，会自动解析并定位到该键名路径下的数组
                'property-new' => '这是新合并进来的数据',
            ],
        ],
    ],
    true // 开启递归模式
);
php
                ,
                'path'      => 'level-1',
                'value'     => [
                    'level-2' => [
                        ':level-3.level-4' => [
                            'property-new' => '这是新合并进来的数据',
                        ],
                    ],
                ],
                'recursive' => true,
                'debug'     => [
                    'level-1' => [
                        'level-2' => [
                            'level-3' => [
                                'level-4' => [
                                    'other'    => '其他神一样的存在',
                                    'tips'     => '开启递归模式后，只会替换指定路径下的键名值，其他属性均被保留',
                                    'property-new' => '这是新合并进来的数据',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title'     => '递归模式同样支持使用`ReplaceArrayValue()`对象替换',
                'array'     => [
                    'level-1' => [
                        'level-2' => [
                            'level-3' => [
                                'level-4' => [
                                    'replace' => '这是用来测试被替换的',
                                    'other'   => '其他神一样的存在',
                                    'tips'    => '开启递归模式后，只会替换指定路径下的键名值，其他属性均被保留',
                                ],
                            ],
                        
                        ],
                    ],
                ],
                'do'        => <<<php
ArrayHelper::setValue(
    \$array,
    'level-1', // 键名路径只获取到`level-1`，但开启递归模式后，后续的数据不会被替换，而是合并
    [
        'level-2' => [
            ':level-3.level-4' => [ // 链式键名配置方式，会自动解析并定位到该键名路径下的数组
                'replace' => new ReplaceArrayValue([
                    'property' => 'value',
                    'tips' => '就算是数组也同样可以使用`ReplaceArrayValue()`对象替换',
                ]),
            ],
        ],
    ],
    true // 开启递归模式
);
php
                ,
                'path'      => 'level-1',
                'value'     => [
                    'level-2' => [
                        ':level-3.level-4' => [
                            'replace' => new ReplaceArrayValue([
                                'property' => 'value',
                                'tips'     => '就算是数组也同样可以使用`ReplaceArrayValue()`对象替换',
                            ]),
                        ],
                    ],
                ],
                'recursive' => true,
                'debug'     => [
                    'level-1' => [
                        'level-2' => [
                            'level-3' => [
                                'level-4' => [
                                    'replace' => [
                                        'property' => 'value',
                                        'tips'     => '就算是数组也同样可以使用`ReplaceArrayValue()`对象替换',
                                    ],
                                    'other'   => '其他神一样的存在',
                                    'tips'    => '开启递归模式后，只会替换指定路径下的键名值，其他属性均被保留',
                                ],
                            ],
                        
                        ],
                    ],
                ],
            ],
            [
                'title'     => '当指定了`class`键名时，所对应的键名路径的数据会被直接替换，而非合并',
                'array'     => [
                    'container' => [
                        'definitions' => [
                            'EngineCore\services\ServiceLocator' => [
                                'locators' => [
                                    'extension' => [
                                        'services' => [
                                            'controller' => [
                                                'model' => [
                                                    'class'         => 'EngineCore\\extension\\repository\\models\\Controller',
                                                    'property-test' => '这是用来测试的属性，执行后将会被替换而非合并',
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'do'        => <<<php
ArrayHelper::setValue(
    \$array,
    'container.definitions.EngineCore\\services\\ServiceLocator',
    [
        // 当指定了`class`键名时，所对应的键名路径的数据会被直接替换，而非合并
        ':locators.extension.services' => [
            ':controller.model' => [
                'class' => '指定了`class`键名会直接替换原有的数据',
            ],
        ],
    ],
    true // 开启递归模式
);
php
                ,
                'path'      => 'container.definitions.EngineCore\services\ServiceLocator',
                'value'     => [
                    ':locators.extension.services' => [
                        ':controller.model' => [
                            'class' => '指定了`class`键名会直接替换原有的数据',
                        ],
                    ],
                ],
                'recursive' => true,
                'debug'     => [
                    'container' => [
                        'definitions' => [
                            'EngineCore\services\ServiceLocator' => [
                                'locators' => [
                                    'extension' => [
                                        'services' => [
                                            'controller' => [
                                                'model' => [
                                                    'class' => '指定了`class`键名会直接替换原有的数据',
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
                'title'     => '如果是以字符串方式包含了`class`键名，这种情况仅会替换`class`值而不会全部替换',
                'array'     => [
                    'container' => [
                        'definitions' => [
                            'EngineCore\services\ServiceLocator' => [
                                'locators' => [
                                    'extension' => [
                                        'services' => [
                                            'controller' => [
                                                'model' => [
                                                    'class' => 'EngineCore\\extension\\repository\\models\\Controller',
                                                    'other' => '其他神一样的存在',
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'do'        => <<<php
ArrayHelper::setValue(
    \$array,
    'container.definitions.EngineCore\\services\\ServiceLocators',
    [
        ':locators.extension.services' => [
            ':controller.model.class' => '字符串形式的包含`class`键名是不会替换全部数据',
        ],
    ],
    true // 开启递归模式
);
php
                ,
                'path'      => 'container.definitions.EngineCore\\services\\ServiceLocator',
                'value'     => [
                    ':locators.extension.services' => [
                        ':controller.model.class' => '字符串形式包含`class`键名是不会替换全部数据',
                    ],
                ],
                'recursive' => true,
                'debug'     => [
                    'container' => [
                        'definitions' => [
                            'EngineCore\services\ServiceLocator' => [
                                'locators' => [
                                    'extension' => [
                                        'services' => [
                                            'controller' => [
                                                'model' => [
                                                    'class' => '字符串形式包含`class`键名是不会替换全部数据',
                                                    'other' => '其他神一样的存在',
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
                'title'     => '递归模式下，如果指定的键名路径不存在，同样会按该路径新增数据',
                'array'     => [
                    'level-1' => [
                        'level-2' => [
                            'other' => '其他神一样的存在',
                        ],
                    ],
                ],
                'do'        => <<<php
ArrayHelper::setValue(
    \$array,
    'level-1',
    [
        ':level-2.property-new' => '我是新增的数据',
    ],
    true // 开启递归模式
);
php
                ,
                'path'      => 'level-1',
                'value'     => [
                    ':level-2.property-new' => '我是新增的数据',
                ],
                'recursive' => true,
                'debug'     => [
                    'level-1' => [
                        'level-2' => [
                            'other'      => '其他神一样的存在',
                            'property-new' => '我是新增的数据',
                        ],
                    ],
                ],
            ],
            [
                'title'     => '当数组键名为数字索引时，同样会执行合并操作',
                'array'     => [
                    'backend' => [
                        'engine-core' => [
                            'items' => [
                                [
                                    'label'      => '最新动态',
                                    'alias_name' => '最新动态',
                                    'show'       => true,
                                ],
                                [
                                    'label'      => '权威指南',
                                    'alias_name' => '权威指南',
                                    'show'       => true,
                                ],
                            ],
                        ],
                    ],
                ],
                'do'        => <<<php
ArrayHelper::setValue(
    \$array,
    'backend.engine-core.items',
    [
        // 默认为数字索引
        [
            'label'      => 'test1',
            'alias_name' => '默认索引为`0`',
            'show'       => true,
        ],
        [
            'label'      => 'test2',
            'alias_name' => '默认索引为`1`',
            'show'       => true,
        ],
    ],
    true // 开启递归模式
);
php
                ,
                'path'      => 'backend.engine-core.items',
                'value'     => [
                    [
                        'label'      => 'test1',
                        'alias_name' => '索引为`0`',
                        'show'       => true,
                    ],
                    [
                        'label'      => 'test2',
                        'alias_name' => '索引为`1`',
                        'show'       => true,
                    ],
                ],
                'recursive' => true,
                'debug'     => [
                    'backend' => [
                        'engine-core' => [
                            'items' => [
                                [
                                    'label'      => '最新动态',
                                    'alias_name' => '最新动态',
                                    'show'       => true,
                                ],
                                [
                                    'label'      => '权威指南',
                                    'alias_name' => '权威指南',
                                    'show'       => true,
                                ],
                                [
                                    'label'      => 'test1',
                                    'alias_name' => '索引为`0`',
                                    'show'       => true,
                                ],
                                [
                                    'label'      => 'test2',
                                    'alias_name' => '索引为`1`',
                                    'show'       => true,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    [
        'title' => '数据删除，该操作是通过为指定的键名路径赋值`UnsetArrayValue()`对象实现删除',
        'items' => [
            [
                'title' => '常规模式',
                'array' => [
                    'level-1' => [
                        'level-2' => [
                            'delete' => '这是用来测试删除的数据',
                            'other'  => '其他神一样的存在',
                        ],
                    ],
                ],
                'do'    => <<<php
ArrayHelper::setValue(
    \$array,
    'level-1.level-2.delete',
    new UnsetArrayValue() // 删除数据
);
php
                ,
                'path'  => 'level-1.level-2.delete',
                'value' => new UnsetArrayValue(),
                'debug' => [
                    'level-1' => [
                        'level-2' => [
                            'other' => '其他神一样的存在',
                        ],
                    ],
                ],
            ],
            [
                'title'     => '递归模式',
                'array'     => [
                    'level-1' => [
                        'level-2' => [
                            'delete' => '这是用来测试删除的数据',
                            'other'  => '其他神一样的存在',
                        ],
                    ],
                ],
                'do'        => <<<php
ArrayHelper::setValue(
    \$array,
    'level-1',
    [
        ':level-2.delete' => new UnsetArrayValue(),
    ],
    true // 开启递归模式
);
php
                ,
                'path'      => 'level-1',
                'value'     => [
                    ':level-2.delete' => new UnsetArrayValue(),
                ],
                'recursive' => true,
                'debug'     => [
                    'level-1' => [
                        'level-2' => [
                            'other' => '其他神一样的存在',
                        ],
                    ],
                ],
            ],
        ],
    ],
    [
        'title' => '当`$path`为`null`',
        'items' => [
            [
                'title' => '常规模式，会直接赋值替代',
                'array' => [
                    'level-1' => [
                        'level-2' => [
                            'other' => '其他神一样的存在',
                        ],
                    ],
                ],
                'do'    => <<<php
ArrayHelper::setValue(
    \$array,
    null, // `\$path`为`null`
    '键名路径为`null`，则直接赋值替代'
);
php
                ,
                'path'  => null,
                'value' => '键名路径为`null`，则直接赋值替代',
                'debug' => '键名路径为`null`，则直接赋值替代',
            ],
            [
                'title'     => '递归模式，会自动从第一层数组开始寻址',
                'array'     => [
                    'level-1' => [
                        'level-2' => [
                            'other'  => '其他神一样的存在',
                            'delete' => '这是用来测试删除的数据',
                        ],
                    ],
                ],
                'do'        => <<<php
ArrayHelper::setValue(
    \$array,
    null, // `\$path`为`null`
    [
        ':level-1.level-2.delete' => new UnsetArrayValue(),
        ':level-1.level-2.other' => '神一样的存在我也能改变你',
        'level-test' => '测试添加新的数据',
    ],
    true // 开启递归模式
);
php
                ,
                'path'      => null,
                'value'     => [
                    ':level-1.level-2.delete' => new UnsetArrayValue(),
                    ':level-1.level-2.other'  => '神一样的存在我也能改变你',
                    'level-test'              => '测试添加新的数据',
                ],
                'recursive' => true,
                'debug'     => [
                    'level-1'    => [
                        'level-2' => [
                            'other' => '神一样的存在我也能改变你',
                        ],
                    ],
                    'level-test' => '测试添加新的数据',
                ],
            ],
        ],
    ],
];

$rowFunc = function ($row) {
    echo '<div class="row">';
    echo '<div class="col-md-6">';
    echo '原数据：';
    $array = $row['array'];
    Ec::dump($array);
    echo '</div>';
    
    echo '<div class="col-md-6">';
    echo '执行操作：';
    echo Html::tag('pre', $row['do']);
    ArrayHelper::setValue($array, $row['path'], $row['value'], $row['recursive'] ?? false);
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
?>