<?php
namespace App\Apie\TypesDemo\Dtos;

use Apie\Core\Dto\DtoInterface;
use Apie\CountryAndPhoneNumber\CountryAndPhoneNumber;
use Apie\CountryAndPhoneNumber\InternationalPhoneNumber;
use Apie\DateValueObjects\DateWithTimezone;
use Apie\DateValueObjects\HourAndMinutes;
use Apie\DateValueObjects\LocalDate;
use Apie\DateValueObjects\Ranges\DateTimeRange;
use Apie\DateValueObjects\Time;
use Apie\DateValueObjects\UnixTimestamp;
use Apie\RegexValueObjects\PhpRegularExpression;
use Apie\SchemaGenerator\Enums\SchemaUsages;
use Apie\TextValueObjects\DatabaseText;
use Apie\TextValueObjects\EncryptedPassword;
use Apie\TextValueObjects\FirstName;
use Apie\TextValueObjects\LastName;
use Apie\TextValueObjects\NonEmptyString;
use Apie\TextValueObjects\SmallDatabaseText;
use Apie\TextValueObjects\StrongPassword;
use App\Apie\TypesDemo\Identifiers\OwnedByUserIdentifier;

class ExampleDto implements DtoInterface
{
    public string $text;

    public int $number;

    public DateTimeRange $range;

    public DateWithTimezone $dateWithTimezone;

    public HourAndMinutes $hourAndMinutes;

    public LocalDate $date;

    public Time $time;

    public UnixTimestamp $timestamp;

    public InternationalPhoneNumber $phoneNumber;

    public CountryAndPhoneNumber $countryAndPhoneNumber;

    public PhpRegularExpression $regularExpression;

    public SchemaUsages $schemaUsage;

    public DatabaseText $databaseText;

    public FirstName $firstName;

    public LastName $lastName;

    public NonEmptyString $nonEmptyString;

    public SmallDatabaseText $smallDatabaseText;

    public StrongPassword $password;

    public OwnedByUserIdentifier $ownedByUser;
}