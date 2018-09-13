<?php


namespace App\Account\Test;


use App\Account\ValueObject\Email;
use App\Account\ValueObject\FirstName;
use App\Account\ValueObject\LastName;
use App\Account\ValueObject\Password;
use PHPUnit\Framework\TestCase;

class ValueObjectTest extends TestCase
{

    /**
     * @author Robert Glazer
     */
    public function testFirstName()
    {
        $examples = [
            'Marek',
            'Michał',
            'Aleksandra',
            'Józef',
            'Łucja',
        ];
        $this->checkCorrectValues($examples, FirstName::class);

        $examplesFalse = [
            ' Michał',
            '@Anna',
            'Robert123',
            'Marta Nowak',
            'asdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasda',
        ];
        $this->checkWrongValues($examplesFalse, FirstName::class);
    }

    /**
     * @author Robert Glazer
     */
    public function testLastName()
    {
        $examplesCorrect = [
            'Twaróg-Nowak',
            'Brzęczyszczykiewicz- nowak Stępień',
            'nowak  Nowak',
        ];
        $this->checkCorrectValues($examplesCorrect, LastName::class);

        $examplesFalse = [
            'Twaróg@#$ -Nowak',
            '@Brzęczyszczykiewicz,nowak,Stępień',
            'nowak,Nowak',
            'nowak Nowak213',
            'asdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasda',
        ];
        $this->checkWrongValues($examplesFalse, LastName::class);
    }

    /**
     * @author Robert Glazer
     */
    public function testEmail()
    {
        $correctEmails = [
            'robertg9@wp.pl',
            'asdadcsvw1231asda21@hotmail.pl',
            'zxcqwehht34gedfe3@onet33.pl'
        ];
        $this->checkCorrectValues($correctEmails, Email::class);

        $wrongEmails = [
            ' asdasd@wp.pl',
            'asdasdśźćż@wp.pl',
            '$##@$asd@wp.pl',
        ];
        $this->checkWrongValues($wrongEmails, Email::class);
    }

    /**
     * @author Robert Glazer
     */
    public function testPassword()
    {
        $correctPasswords = [
            'asd123sad!@#&^&*))(_+-=p[]":<>',
            '123$%^%^@#*()()_+_csdg',
            'asd23tsdgf',
            'asdfasdfwefwe',
            '34534563456',
        ];
        $this->checkCorrectValues($correctPasswords, Password::class);

        $wrongPasswords = [
            ' asdasdasdasd',
            'śźćżźćóósdfsdf',
            '   asdasdasd',
            'asd@',
            '',
        ];
        $this->checkWrongValues($wrongPasswords, Password::class);
    }

    /**
     * @param array $values
     * @param string $valueObjectName
     * @author Robert Glazer
     */
    private function checkCorrectValues(array $values, string $valueObjectName): void
    {
        $passed = true;
        foreach ($values as $example) {
            try {
                $valueObject = new $valueObjectName($example);
            } catch (\Exception $exception) {
                $passed = false;
                break;
            }
        }

        $this->assertTrue($passed);
    }

    /**
     * @param array $values
     * @param string $valueObjectName
     * @author Robert Glazer
     */
    private function checkWrongValues(array $values, string $valueObjectName): void
    {
        $passed = false;
        foreach ($values as $example) {
            try {
                $valueObject = new $valueObjectName($example);
                $passed = true;
            } catch (\Exception $exception) {
            }
        }

        $this->assertFalse($passed);
    }

}