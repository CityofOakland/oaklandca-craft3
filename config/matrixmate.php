<?php

$defaultTextBlock = [
  'label' => 'Text',
  'types' => ['heading', 'subheading', 'text'],
];
$defaultLinksBlock = [
  'label' => 'Links',
  'types' => ['largeEntryLinks', 'smallEntryLinks', 'newsEntries', 'eventEntries', 'meetingEntries']
];
$defaultImagesBlock = [
  'label' => 'Images',
  'types' => ['image', 'gallery']
];
$defaultTablesBlock = [
  'label' => 'Tables',
  'types' => ['table2Columns', 'table3Columns', 'table4Columns']
];

$user = Craft::$app->getUser();
$isUserAdmin = $user->getIsAdmin();
$isContentBuilder = $user->getIdentity() ? $user->getIdentity()->isInGroup('contentBuilderUser') : null;

if ($isUserAdmin) {
  $defaultBlock = [
    $defaultTextBlock,
    $defaultLinksBlock,
    $defaultImagesBlock,
    $defaultTablesBlock
  ];
  $departmentsBlock = $defaultBlock;
  $topicsBlock = $defaultBlock;
  $newsPressBlock = $defaultBlock;
  $resourcesBlock = $defaultBlock;
  $servicesBlock = $defaultBlock;
}
elseif ($isContentBuilder) {
  $defaultBlock = [
    $defaultTextBlock,
  ];
  $departmentsBlock = [
    $defaultTextBlock,
    $defaultLinksBlock,
  ];
  $topicsBlock = [
    $defaultTextBlock,
    $defaultLinksBlock,
    $defaultImagesBlock,
    $defaultTablesBlock
  ];
  $newsPressBlock = [
    $defaultTextBlock,
    $defaultImagesBlock,
    $defaultTablesBlock
  ];
  $resourcesBlock = [
    $defaultTextBlock,
    $defaultImagesBlock,
    $defaultTablesBlock
  ];
  $servicesBlock = [
    $defaultTextBlock,
    $defaultLinksBlock,
  ];
}
else {
  $defaultBlock = [''];
  $departmentsBlock = $defaultBlock;
  $topicsBlock = $defaultBlock;
  $newsPressBlock = $defaultBlock;
  $resourcesBlock = [
    $defaultTextBlock,
  ];
  $servicesBlock = [
    $defaultTextBlock
  ];
};

return [
  'fields' => [
    'contentBuilder' => [
      '*' => [
        'groups' => $defaultBlock,
        'hideUngroupedTypes' => true
      ],
      'section:departments,section:boardsCommissions' =>[
        'groups' => $departmentsBlock,
        'hideUngroupedTypes' => true,
      ],
      'section:topics' => [
        'groups' => $topicsBlock,
        'hideUngroupedTypes' => true,
      ],
      'section:news,section:pressReleases' => [
        'groups' => $newsPressBlock,
        'hideUngroupedTypes' => true,
      ],
      'section:resources' => [
        'groups' => $resourcesBlock,
        'hideUngroupedTypes' => true,
      ],
      'section:services' => [
        'groups' => $servicesBlock,
        'hideUngroupedTypes' => true,
      ],
    ],
  ],
];