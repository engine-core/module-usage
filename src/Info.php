<?php
/**
 * @link https://github.com/engine-core/module-usage
 * @copyright Copyright (c) 2021 engine-core
 * @license BSD 3-Clause License
 */

declare(strict_types=1);

namespace EngineCore\modules\usage;

use EngineCore\enums\AppEnum;
use EngineCore\extension\repository\info\ModularityInfo;
use Yii;

class Info extends ModularityInfo
{

    protected
        $id = 'usage',
        $name = '用法示例';

    /**
     * {@inheritdoc}
     */
    public function getMenus(): array
    {
        return [
            AppEnum::BACKEND => [
                'usage' => [
                    'label' => Yii::t('ec/modules/usage', 'Usage'),
                    'icon' => 'book',
                    'visible' => true,
                    'order' => 9998,
                    'items' => [
                        'ArrayHelper' => [
                            'label' => 'EngineCore\helpers\ArrayHelper',
                            'icon' => 'terminal',
                            'visible' => true,
                            'items' => [
                                [
                                    'label' => 'setValue()',
                                    'icon' => 'file-code-o',
                                    'url' => "/{$this->id}/array-helper/setValue",
                                    'visible' => true,
                                ],
                                [
                                    'label' => 'superMerge()',
                                    'icon' => 'file-code-o',
                                    'url' => "/{$this->id}/array-helper/superMerge",
                                    'visible' => true,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig(): array
    {
        return [
            'modules' => [
                $this->id => [
                    'class' => 'EngineCore\modules\usage\Module',
                ],
            ],
            'components' => [
                'i18n' => [
                    'translations' => [
                        'ec/modules/usage' => [
                            'class' => 'yii\\i18n\\PhpMessageSource',
                            'sourceLanguage' => 'en-US',
                            'basePath' => '@EngineCore/modules/usage/messages',
                            'fileMap' => [
                                'ec/modules/usage' => 'app.php',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

}