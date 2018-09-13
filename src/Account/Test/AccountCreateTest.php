<?php


namespace App\Account\Test;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccountCreateTest extends WebTestCase
{

    /**
     * @author Robert Glazer
     */
    public function testAccountCreate()
    {
        $this->accountCreateCorrectValues();
        $this->accountCreateWrongValues();
    }

    /**
     * @author Robert Glazer
     */
    private function accountCreateCorrectValues()
    {
        $correctDataModels = [
            [
                'first_name' => 'casa',
                'last_name' => 'testc',
                'email' => 'test4@wp.pl',
                'password' => 'test123!@#',
            ],
            [
                'first_name' => 'Robert',
                'last_name' => 'Glazer',
                'email' => 'asdasdasdas@wsdp.pl',
                'password' => 'asdasd@#asdasP{{',
            ],
        ];

        foreach ($correctDataModels as $dataModel) {
            $this->assertEquals(200, $this->getAccountCreateResponseCode($dataModel));
        }
    }

    /**
     * @author Robert Glazer
     */
    private function accountCreateWrongValues(): void
    {
        $wrongDataModels = [
            [
                'first_name' => 'casa2',
                'last_name' => 'testc',
                'email' => 'test4@wp.pl',
                'password' => 'test123!@#',
            ],
            [
                'first_name' => 'casa',
                'last_name' => 'testc ',
                'email' => 'test4',
                'password' => 'a',
            ],
            [
                'first_name' => 'casa',
                'last_name' => 'testc',
                'email' => 'test4',
                'password' => 'a',
            ],
            [
                'first_name' => 'casa',
                'last_name' => 'testc',
                'email' => 'test4@wp.pl',
                'password' => 'a',
            ],
        ];

        foreach ($wrongDataModels as $dataModel) {
            $this->assertEquals(400, $this->getAccountCreateResponseCode($dataModel));
        }
    }

    /**
     * @param array $data
     * @return int
     * @author Robert Glazer
     */
    private function getAccountCreateResponseCode(array $data): int
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/account',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $client->getResponse();
        return (int)$response->getStatusCode();
    }

}