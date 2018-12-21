<?php
use craft\elements\Entry;
use craft\helpers\UrlHelper;
use Solspace\Calendar\Elements\Event;
use fruitstudios\linkit\Linkit;
use League\Fractal\TransformerAbstract;

class eventsTransform extends TransformerAbstract
{
  public function transform(Solspace\Calendar\Elements\Event $event)
  {
    $boardsCommissions = [];
    foreach($event->boardsCommissions->all() as $value)
      $boardsCommissions[] = $value->title;
    $departments = [];
    foreach($event->departments->all() as $value)
      $departments[] = $value->title;
    $electedOfficials = [];
    foreach($event->electedOfficials->all() as $value)
      $electedOfficials[] = $value->title;
    $projects = [];
    foreach($event->projects->all() as $value)
      $projects[] = $value->title;
    $topics = [];
    foreach($event->topics->all() as $value)
      $topics[] = $value->title;
    return [
      'title' => $event->title,
      'url' => $event->url,
      'date' => $event->startDate->timestamp,
      'displayDate' => $event->startDate->format('F j, Y'),
      'body' => (string) $event->body,
      'contact' => (string) $event->eventContact,
      'eventImage' => ! empty($event->eventImage->one()) ? (string) $event->eventImage->one()->getUrl('smallSquare') : null,
      'boardsCommissions' => $boardsCommissions,
      'departments' => $departments,
      'electedOfficials' => $electedOfficials,
      'projects' => $projects,
      'topics' => $topics,
    ];
  }
}

return [
  "sync" => true,
  "application_id" => getenv('ALGOLIA_APP_ID'),
  "admin_api_key" => getenv('ALGOLIA_ADMIN_API'),
  "mappings" => [
    // BEGIN NEWS INDEX
    [
      'indexName' => getenv('ENVIRONMENT') . '_news_test',
      'indexSettings' => [
        'settings' => [
            'attributesForFaceting' => [
              'boardsCommissions',
              'departments',
              'projects',
              'electedOfficials',
              'topics'
            ],
        ],
        'forwardToReplicas' => 'true',
      ],
      'elementType' => \craft\elements\Entry::class,
      'criteria' => [
        'section' => 'news'
      ],
      'transformer' => function(craft\elements\Entry $entry) {
        $boardsCommissions = [];
        foreach($entry->boardsCommissions->all() as $value)
          $boardsCommissions[] = $value->title;
        $departments = [];
        foreach($entry->departments->all() as $value)
          $departments[] = $value->title;
        $electedOfficials = [];
        foreach($entry->electedOfficials->all() as $value)
          $electedOfficials[] = $value->title;
        $projects = [];
        foreach($entry->projects->all() as $value)
          $projects[] = $value->title;
        $topics = [];
        foreach($entry->topics->all() as $value)
          $topics[] = $value->title;
        return [
          'title' => $entry->title,
          'url' => $entry->url,
          'newsImage' => ! empty($entry->newsImage->one()) ? (string) $entry->newsImage->one()->url : null,
          'summary' => (string) $entry->summary,
          'body' => (string) $entry->body,
          'mediaContact' => (string) $entry->mediaContact,
          'boardsCommissions' => $boardsCommissions,
          'departments' => $departments,
          'projects' => $projects,
          'electedOfficials' => $electedOfficials,
          'topics' => $topics,
        ];
      },
    ],
    // END NEWS INDEX
    // BEGIN BOARDS INDEX
    [
      'indexName' => getenv('ENVIRONMENT') . '_boards',
      'elementType' => \craft\elements\Entry::class,
      'criteria' => [
        'section' => 'boardsCommissions',
        'type' => 'boardsCommissions'
      ],
      'transformer' => function(craft\elements\Entry $entry) {
        return [
          'title' => $entry->title,
          'url' => $entry->url,
          'date' => $entry->postDate,
          'banner' => ! empty($entry->banner->one()) ? (string) $entry->banner->one()->url : null,
          'ctaButtonText' => ! empty($entry->ctaButton->text) ? (string) $entry->ctaButton->text : null,
          'leadIn' => (string) $entry->leadIn,
          'about' => (string) $entry->about,
        ];
      },
    ],
    // END BOARDS INDEX
    // BEGIN DEPARTMENTS INDEX
    [
      'indexName' => getenv('ENVIRONMENT') . '_departments',
      'elementType' => \craft\elements\Entry::class,
      'criteria' => [
        'section' => 'departments',
        'type' => 'departments'
      ],
      'transformer' => function(craft\elements\Entry $entry) {
        return [
          'title' => $entry->title,
          'url' => $entry->url,
          'banner' => ! empty($entry->banner->one()) ? (string) $entry->banner->one()->url : null,
          'ctaButtonText' => ! empty($entry->ctaButton->text) ? (string) $entry->ctaButton->text : null,
          'leadIn' => (string) $entry->leadIn,
          'groupHeadName' => (string) $entry->groupHeadName,
          'groupHeadTitle' => (string) $entry->groupHeadTitle,
          'groupHeadBio' => (string) $entry->groupHeadBio,
          'groupHeadPortrait' => ! empty($entry->portrait->one()) ? (string) $entry->portrait->one()->url : null,
        ];
      },
    ],
    [
      'indexName' => getenv('ENVIRONMENT') . '_departments',
      'elementType' => \craft\elements\Entry::class,
      'criteria' => [
        'section' => 'departments',
        'type' => 'cityCouncil'
      ],
      'transformer' => function(craft\elements\Entry $entry) {
        $officials = [];
        foreach($entry->pageOfficials->all() as $value)
          $officials[] = [$value->title, $value->groupHeadName];
        return [
          'title' => $entry->title,
          'url' => $entry->url,
          'banner' => ! empty($entry->banner->one()) ? (string) $entry->banner->one()->url : null,
          'ctaButtonText' => ! empty($entry->ctaButton->text) ? (string) $entry->ctaButton->text : null,
          'leadIn' => $entry->leadIn,
          'officials' => $officials,
        ];
      },
    ],
    // END DEPARTEMNTS INDEX
    // BEGIN DOCUMENTS INDEX
    [
      'indexName' => getenv('ENVIRONMENT') . '_documents',
      'indexSettings' => [
        'settings' => [
            'attributesForFaceting' => ['categories', 'boardsCommissions', 'departments', 'electedOfficials', 'projects', 'resources', 'services', 'topics'],
        ],
        'forwardToReplicas' => 'true',
      ],
      'elementType' => \craft\elements\Entry::class,
      'criteria' => [
        'section' => 'documents'
      ],
      'transformer' => function(craft\elements\Entry $entry) {
        $boardsCommissions = [];
        foreach($entry->boardsCommissions->all() as $value)
          $boardsCommissions[] = $value->title;
        $departments = [];
        foreach($entry->departments->all() as $value)
          $departments[] = $value->title;
        $electedOfficials = [];
        foreach($entry->electedOfficials->all() as $value)
          $electedOfficials[] = $value->title;
        $projects = [];
        foreach($entry->projects->all() as $value)
          $projects[] = $value->title;
        $resources = [];
        foreach($entry->resources->all() as $value)
          $resources[] = $value->title;
        $services = [];
        foreach($entry->services->all() as $value)
          $services[] = $value->title;
        $topics = [];
        foreach($entry->topics->all() as $value)
          $topics[] = $value->title;
        $types = [];
        foreach($entry->documentType->all() as $value)
          $types[] = $value->title;
        return [
          'title' => $entry->title,
          'url' => $entry->url,
          'summary' => (string) $entry->summary,
          'categories' => $types,
          'boardsCommissions' => $boardsCommissions,
          'departments' => $departments,
          'electedOfficials' => $electedOfficials,
          'projects' => $projects,
          'resources' => $resources,
          'services' => $services,
          'topics' => $topics,
        ];
      },
    ],
    [
      'indexName' => getenv('ENVIRONMENT') . '_documents',
      'elementType' => \craft\elements\Entry::class,
      'criteria' => [
        'section' => 'documentPackets'
      ],
      'transformer' => function(craft\elements\Entry $entry) {
        $documents = [];
        foreach($entry->documents->all() as $value)
          $documents[] = $value->title;
        return [
          'title' => $entry->title,
          'url' => $entry->url,
          'leadIn' => (string) $entry->leadIn,
          'summary' => (string) $entry->summary,
          'documents' => $documents,
        ];
      },
    ],
    // END DOCUMENTS INDEX
    // BEGIN PROJECTS INDEX
    [
      'indexName' => getenv('ENVIRONMENT') . '_projects',
      'elementType' => \craft\elements\Entry::class,
      'criteria' => [
        'section' => 'projects'
      ],
      'transformer' => function(craft\elements\Entry $entry) {
        $milestones = [];
        foreach ($entry->timeline->all() as $block) {
          $milestones[] = [
            'name' => (string) $block->milestoneName,
            'dates' => (string) $block->milestoneDates
          ];
        }
        $boardsCommissions = [];
        foreach($entry->boardsCommissions->all() as $value)
          $boardsCommissions[] = $value->title;
        $departments = [];
        foreach($entry->departments->all() as $value)
          $departments[] = $value->title;
        $electedOfficials = [];
        foreach($entry->electedOfficials->all() as $value)
          $electedOfficials[] = $value->title;
        $topics = [];
        foreach($entry->topics->all() as $value)
          $topics[] = $value->title;
        return [
          'title' => $entry->title,
          'url' => $entry->url,
          'banner' => ! empty($entry->banner->one()) ? (string) $entry->banner->one()->url : null,
          'leadIn' => (string) $entry->leadIn,
          'about' => (string) $entry->about,
          'boardsCommissions' => $boardsCommissions,
          'departments' => $departments,
          'electedOfficials' => $electedOfficials,
          'topics' => $topics,
        ];
      },
    ],
    // END PROJECTS INDEX
    // BEGIN RESOURCES INDEX
    [
      'indexName' => getenv('ENVIRONMENT') . '_resources',
      'elementType' => \craft\elements\Entry::class,
      'criteria' => [
        'section' => 'resources'
      ],
      'transformer' => function(craft\elements\Entry $entry) {
        $boardsCommissions = [];
        foreach($entry->boardsCommissions->all() as $value)
          $boardsCommissions[] = $value->title;
        $departments = [];
        foreach($entry->departments->all() as $value)
          $departments[] = $value->title;
        $electedOfficials = [];
        foreach($entry->electedOfficials->all() as $value)
          $electedOfficials[] = $value->title;
        $projects = [];
        foreach($entry->projects->all() as $value)
          $projects[] = $value->title;
        $topics = [];
        foreach($entry->topics->all() as $value)
          $topics[] = $value->title;
        $body = [];
        foreach ($entry->transactionBody->all() as $block) {
          $body[] = strip_tags($block->text);
        }
        return [
          'title' => $entry->title,
          'url' => $entry->url,
          'resourceImage' => ! empty($entry->resourceImage->one()) ? (string) $entry->resourceImage->one()->url : null,
          'leadIn' => (string) $entry->leadIn,
          'boardsCommissions' => $boardsCommissions,
          'departments' => $departments,
          'electedOfficials' => $electedOfficials,
          'projects' => $projects,
          'topics' => $topics,
          'body' => $body,
        ];
      },
    ],
    // END RESOURCES INDEX
    // BEGIN SERVICES INDEX
    [
      'indexName' => getenv('ENVIRONMENT') . '_services',
      'elementType' => \craft\elements\Entry::class,
      'criteria' => [
        'section' => 'services',
        'type' => 'services'
      ],
      'transformer' => function(craft\elements\Entry $entry) {
        $boardsCommissions = [];
        foreach($entry->boardsCommissions->all() as $value)
          $boardsCommissions[] = $value->title;
        $departments = [];
        foreach($entry->departments->all() as $value)
          $departments[] = $value->title;
        $electedOfficials = [];
        foreach($entry->electedOfficials->all() as $value)
          $electedOfficials[] = $value->title;
        $projects = [];
        foreach($entry->projects->all() as $value)
          $projects[] = $value->title;
        $topics = [];
        foreach($entry->topics->all() as $value)
          $topics[] = $value->title;
        $body = [];
        foreach ($entry->transactionBody->all() as $block) {
          $body[] = (string) $block->text;
        }
        return [
          'title' => $entry->title,
          'url' => $entry->url,
          'leadIn' => (string) $entry->leadIn,
          'boardsCommissions' => $boardsCommissions,
          'departments' => $departments,
          'electedOfficials' => $electedOfficials,
          'projects' => $projects,
          'topics' => $topics,
          'body' => $body,
        ];
      },
    ],
    [
      'indexName' => getenv('ENVIRONMENT') . '_services',
      'elementType' => \craft\elements\Entry::class,
      'criteria' => [
        'section' => 'services',
        'type' => 'services311'
      ],
      'transformer' => function(craft\elements\Entry $entry) {
        return [
          'title' => $entry->title,
          'url' => $entry->url,
          'banner' => ! empty($entry->banner->one()) ? (string) UrlHelper::siteUrl($entry->banner->one()->url) : null,
          'leadIn' => (string) $entry->leadIn,
          'body' => (string) $entry->body,
          'urgentIssuesDescription' => (string) $entry->urgentIssuesDescription,
          'nonUrgentIssuesDescription' => (string) $entry->nonUrgentIssuesDescription,
        ];
      },
    ],
    // END SERVICES INDEX
    // BEGIN TOPICS INDEX
    [
      'indexName' => getenv('ENVIRONMENT') . '_topics',
      'elementType' => \craft\elements\Entry::class,
      'criteria' => [
        'section' => 'topics'
      ],
      'transformer' => function(craft\elements\Entry $entry) {
        $boardsCommissions = [];
        foreach($entry->boardsCommissions->all()->all() as $value)
          $boardsCommissions[] = $value->title;
        $departments = [];
        foreach($entry->departments->all()->all() as $value)
          $departments[] = $value->title;
        $electedOfficials = [];
        foreach($entry->electedOfficials->all()->all() as $value)
          $electedOfficials[] = $value->title;
        $projects = [];
        foreach($entry->projects->all()->all() as $value)
          $projects[] = $value->title;
        $topics = [];
        foreach($entry->topics->all()->all() as $value)
          $topics[] = $value->title;
        return [
          'title' => $entry->title,
          'url' => $entry->url,
          'banner' => ! empty($entry->banner->one()) ? (string) $entry->banner->one()->url : null,
          'leadIn' => (string) $entry->leadIn,
          'about' => (string) $entry->about,
          'boardsCommissions' => $boardsCommissions,
          'departments' => $departments,
          'electedOfficials' => $electedOfficials,
          'projects' => $projects,
          'topics' => $topics,
        ];
      },
    ],
    // END TOPICS INDEX
    // BEGIN EVENTS INDEX
    [
      'indexName' => getenv('ENVIRONMENT') . '_events',
      'indexSettings' => [
        'settings' => [
            'attributesForFaceting' => ['boardsCommissions', 'departments', 'projects', 'electedOfficials', 'topics'],
        ],
        'forwardToReplicas' => 'true',
      ],
      'elementType' => \Solspace\Calendar\Elements\Event::class,
      'criteria' => [
        'calendar' => 'events',
      ],
      'transformer' => new eventsTransform(),
    ],
    // END EVENTS INDEX
    // BEGIN MEETINGS INDEX
    [
      'indexName' => getenv('ENVIRONMENT') . '_meetings',
      'indexSettings' => [
        'settings' => [
            'attributesForFaceting' => ['boardsCommissions', 'departments', 'projects', 'electedOfficials', 'topics'],
        ],
        'forwardToReplicas' => 'true',
      ],
      'elementType' => \Solspace\Calendar\Elements\Event::class,
      'criteria' => [
        'calendar' => 'meetings',
      ],
      'transformer' => new eventsTransform(),
    ],
    // END MEETINGS INDEX
    // BEGIN CALENDAR INDEX
    [
      'indexName' => getenv('ENVIRONMENT') . '_calendars',
      'indexSettings' => [
        'settings' => [
            'attributesForFaceting' => ['boardsCommissions', 'departments', 'projects', 'electedOfficials', 'topics'],
        ],
        'forwardToReplicas' => 'true',
      ],
      'elementType' => \Solspace\Calendar\Elements\Event::class,
      'criteria' => [
        'calendar' => 'events',
      ],
      'transformer' => new eventsTransform(),
    ],
    [
      'indexName' => getenv('ENVIRONMENT') . '_calendars',
      'indexSettings' => [
        'settings' => [
            'attributesForFaceting' => ['boardsCommissions', 'departments', 'projects', 'electedOfficials', 'topics'],
        ],
        'forwardToReplicas' => 'true',
      ],
      'elementType' => \Solspace\Calendar\Elements\Event::class,
      'criteria' => [
        'calendar' => 'meetings',
      ],
      'transformer' => new eventsTransform(),
    ],
    // END CALENDAR INDEX
    // BEGIN STAFF INDEX
    [
      'indexName' => getenv('ENVIRONMENT') . '_staff',
      'elementType' => \craft\elements\Entry::class,
      'criteria' => [
        'section' => 'staff',
        'type' => 'staff'
      ],
      'transformer' => function(craft\elements\Entry $entry) {
        return [
          'title' => $entry->title,
          'url' => $entry->url,
          'portrait' => ! empty($entry->portrait->one()) ? (string) $entry->portrait->one()->url : null,
          'jobTitle' => ! empty($entry->jobTitle) ? (string) $entry->jobTitle : (string) $entry->staffImportJobTitle,
          'bio' => (string) $entry->bio,
          'email' => ! empty($entry->emailAddress) ? (string) $entry->emailAddress : (string) $entry->staffImportEmail,
          'department' => ! empty($entry->departments->one()) ? (string) $entry->departments->one()->title : $entry->staffImportDepartment,
          'employmentType' => (string) $entry->employmentType->label,
        ];
      },
    ],
    // END STAFF INDEX
    // BEGIN VOLUNTEERS INDEX
    [
      'indexName' => getenv('ENVIRONMENT') . '_volunteers',
      'elementType' => \craft\elements\Entry::class,
      'criteria' => [
        'section' => 'volunteers',
        'type' => 'volunteers'
      ],
      'transformer' => function(craft\elements\Entry $entry) {
        return [
          'title' => $entry->title,
          'url' => $entry->url,
          'portrait' => ! empty($entry->portrait->one()) ? (string) $entry->portrait->one()->url : null,
          'jobTitle' => ! empty($entry->jobTitle) ? (string) $entry->jobTitle : null,
          'bio' => (string) $entry->bio,
          'email' => ! empty($entry->emailAddress) ? (string) $entry->emailAddress : null,
          'department' => ! empty($entry->departmentOfficialBoardCommission->one()) ? (string) $entry->departmentOfficialBoardCommission->one()->title : null,
        ];
      },
    ],
    // END VOLUNTEERS INDEX
    // BEGIN TEAMS INDEX
    [
      'indexName' => getenv('ENVIRONMENT') . '_teams',
      'elementType' => \craft\elements\Entry::class,
      'criteria' => [
        'section' => 'teams',
        'type' => 'teams'
      ],
      'transformer' => function(craft\elements\Entry $entry) {
        $teamMembers = [];
        foreach($entry->teamMembers->all() as $value)
          foreach($value->staff->all() as $teamMember)
            $teamMembers[] = $teamMember->title;
        return [
          'title' => $entry->title,
          'url' => $entry->url,
          'teamMembers' => $teamMembers,
        ];
      },
    ],
    // END TEAMS INDEX
  ],
];
