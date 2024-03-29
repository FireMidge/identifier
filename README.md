# Identifier

This little library provides interfaces (and implementations) to turn IDs into value objects.


## Quality Control

The following table is updated with each code update and is generated with the help of PhpUnit (unit testing tool) and Infection (mutation testing tool):

| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | Percentage                | Description                                                                                                                                                                                                                                                                                                                            |
|:-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|:--------------------------|:---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| Code Coverage                                                                                                                                                                                                                                                | ![100%](docs/img/cc.png)  | How many methods have been fully covered by tests.                                                                                                                       |
| Mutation Score Indicator                                                                                                                                                                                                                                     | ![85%](docs/img/msi.png)  | Indicates how many generated mutants were detected. *Note that some mutants are false positives.*                                                                                                                                                                                                                                      |
| Mutation Code Coverage                                                                                                                                                                                                                                       | ![100%](docs/img/mcc.png) | Should be in the same ballpark as the normal code coverage. Formula: `(TotalMutantsCount - NotCoveredByTestsCount) / TotalMutantsCount`                                                                                                                                                                                                |
| Covered Code MSI                                                                                                                                                                                                                                             | ![85%](docs/img/ccm.png)  | This is the MSI (Mutation Score Indicator) for code that is actually covered by tests. It shows how effective the tests really are. Formula: `TotalDefeatedMutants / (TotalMutantsCount - NotCoveredByTestsCount)`. *Note that for some reason, Infection reports some mutants not being covered by tests when they actually are.* |


## Why use value objects instead of scalar types?

There are many benefits, but perhaps the most notable ones are listed below.


### Expressiveness
Using value objects means your type hints become much more expressive. It is clearer what needs to be passed (and/or returned) even if your code is lacking docblocks, e.g.

```public function findById(UserId $id) : ?User;```

as opposed to:

```public function findById(string $id) : ?User;```


### Validation

Especially if you use UUIDs as identifiers for which no scalar type exists, you will benefit from additional validation, e.g. if you read IDs from user input or URLs.

```$userId = UserId::fromString($idString);```

You can even add additional validation on top to verify the ID is the ID of an existing entity and does not just match by format.


### Early error detection if passed in wrong order

Consider an arguments list like this:

```public function __construct(string $id, string $projectId, string $creatorId)```

If you call this constructor with the parameters in the wrong order (which can easily happen if you refactored the signature at some point), neither your IDE nor runtime will be able to detect the error, and you will likely get an entity not found error at a later point in time that is a lot less obvious to debug. On the other hand, if your signature looked like this:

```public function __construct(FileId $id, ProjectId $projectId, CreatorId $creatorId)```

... your IDE (if you use a decent one) will already be able to detect any parameters passed in the wrong order - at the latest, you will find out at runtime with a much more useful error that will lead you straight to the mistake.


### Type changes

Using value objects as identifiers also means you can change the type of identifier later down the line without affecting the rest of your codebase, e.g. from a numeric ID to a UUID. All you'd have to do is change your identifier value object to extend from a different type of identifier.

If changing the type of identifier is something you are considering for your project, try to stick to using methods available directly on the `Identifier` interface instead of the more specific methods on more specific interfaces to aid with the transition.


## How to use this library

You could type hint for UuidIdentifier or IntIdentifier directly within your code base, however, for the biggest benefit it is recommended to create your own very specific classes extending from one of the identifier implementations (or create your own and implement the Identifier interface).

Examples:

```injectablephp
<?php
declare(strict_types=1);

namespace My\Own;

use FireMidge\Identifier\Implementation\UuidId;

class FileId extends UuidId
{
}
```

There is no class body required.

Usage:

```injectablephp
$fileId = FileId::fromString('4ab01c13-f9c2-4bbc-9b6b-95c416d99593');

$newFileId = FileId::generate();
```
