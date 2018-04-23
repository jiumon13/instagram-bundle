<?php

namespace xyz13\InstagramBundle\Instagram;

use Facebook\WebDriver\Exception\NoSuchWindowException;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Symfony\Component\HttpFoundation\Request;
use xyz13\InstagramBundle\Client\HttpClient;

class Factory
{
    /**
     * @var HttpClient
     */
    private $client;

    /**
     * InstagramWebDriverFactory constructor.
     *
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return Instagram
     *
     * @throws \xyz13\InstagramBundle\Client\HttpClientException
     */
    public function get()
    {
        $response = $this->client->request('http://browser:4444/wd/hub/sessions');

        $sessionId = $response[1]['value'][0]['id'] ?? null;

        if (null !== $sessionId) {
            $webDriver = RemoteWebDriver::createBySessionID(
                $sessionId,
                'http://browser:4444/wd/hub'
            );
        } else {
            $webDriver = RemoteWebDriver::create(
                'http://browser:4444/wd/hub',
                DesiredCapabilities::chrome()
            );

            $sessionId = $webDriver->getSessionID();
        }

        $this->client->request(sprintf('http://browser:4444/wd/hub/session/%s/local_storage', $sessionId), Request::METHOD_DELETE);
        $this->client->request(sprintf('http://browser:4444/wd/hub/session/%s/session_storage', $sessionId), Request::METHOD_DELETE);
        $webDriver->manage()->deleteAllCookies();

        try {
            $webDriver->getCurrentURL();
        } catch (NoSuchWindowException $e) {
            $webDriver->quit();

            $webDriver = RemoteWebDriver::create(
                'http://browser:4444/wd/hub',
                DesiredCapabilities::chrome()
            );

            $webDriver->get('http://google.com');
        }

//        $login = 'iframe_alina';
//        $password = '199696';
//        $login = 'blessed_staff_bot';
//        $password = 'caribbean13121996';
//        $login = 'ilona_garkusha';
//        $password = '1234567890Aa';
//        $login = 'prodam_svoe_tebe';
//        $password = '199696';
//        $login = 'ilikeit2939';
//        $password = 'ju789lkixyz';
//
//        $driver->navigate()->refresh();
//        $driver->get('https://instagram.com');
//        $this->driver->execute(DriverCommand::MAXIMIZE_WINDOW);
//
//        try {
//
//            $driver
//                ->wait(10)
//                ->until(
//                    WebDriverExpectedCondition::presenceOfElementLocated(
//                        WebDriverBy::xpath('//a[contains(text(), "' . $login . '")]')
//                    )
//                );
//
//        } catch (NoSuchElementException $e) {
//            $driver->wait()->until(
//                function () use ($driver) {
//                    $elements = $driver->findElements(WebDriverBy::xpath(
//                        '//*[@id="react-root"]/section/main/article/div[2]/div[2]/p/a'
//                    ));
//
//                    return count($elements) > 0;
//                }
//            );
//
//            $element = $driver->findElement(WebDriverBy::xpath(
//                '//*[@id="react-root"]/section/main/article/div[2]/div[2]/p/a'
//            ));
//
//            $element->click();
//            $driver->wait()->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector(
//                'input[name=username]'
//            )));
//
//            $driver->findElement(WebDriverBy::cssSelector('input[name=username]'))->sendKeys($login);
//            sleep(rand(2, 7));
//            $driver->findElement(WebDriverBy::cssSelector('input[name=password]'))->sendKeys($password);
//
//            $submit = $driver->findElement(WebDriverBy::xpath(
//                '//*[@id="react-root"]/section/main/article/div[2]/div[1]/div/form/span/button'
//            ));
//
//            $driver->action()->moveToElement($submit);
//            $point = $submit->getLocationOnScreenOnceScrolledIntoView();
//            $driver->getMouse()->mouseMove($submit->getCoordinates(), $point->getX(), $point->getY())->click();
//            sleep(1);
//
//            $submit->click();
//            sleep(rand(2, 7));
//
//            try {
//
//                $driver
//                    ->wait(10)
//                    ->until(
//                        WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::xpath(
//                            '//a[contains(text(), "' . $login . '")]'
//                        ))
//                    );
//
//            } catch (NoSuchElementException $e) {
//
//                $driver
//                    ->wait()
//                    ->until(
//                        WebDriverExpectedCondition::presenceOfElementLocated(
//                            WebDriverBy::xpath('//button[text() = \'Send Security Code\']')
//                        )
//                    );
//
//                $button = $driver->findElement(WebDriverBy::xpath('//button[text() = \'Send Security Code\']'));
//
//                $driver->action()->moveToElement($button);
//                $point = $button->getLocationOnScreenOnceScrolledIntoView();
//                $driver->getMouse()->mouseMove($button->getCoordinates(), $point->getX(), $point->getY())->click();
//                $button->click();
//
//                sleep(60);
//
//                $mailDriver = RemoteWebDriver::create(
//                    'http://browser:4444/wd/hub',
//                    DesiredCapabilities::chrome()
//                );
//
//                $mailDriver->get('https://mail.ru');
//
//                $mailDriver->wait()->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::xpath('//*[@id="mailbox:login"]')));
//                $mailDriver->findElement(WebDriverBy::xpath('//*[@id="mailbox:login"]'))->sendKeys('tes');
//                $mailDriver->findElement(WebDriverBy::xpath('//*[@id="mailbox:password"]'))->sendKeys('tes');
//                $mailDriver->findElement(WebDriverBy::xpath('//*[@id="mailbox:submit"]'))->click();
//
//                $mailDriver->wait(1000)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::xpath(
//                    '//div[contains(@class, "b-datalist__item_unread")]//div[text()="Instagram"]'
//                )));
//
//                $elements = $mailDriver->findElements(WebDriverBy::xpath(
//                    '//div[contains(@class, "b-datalist__item_unread")]//div[text()="Instagram"]'
//                ));
//
//                $elements[0]->click();
//
//                $mailDriver->wait()->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::xpath(
//                    '//*[@id="email_content_mailru_css_attribute_postfix"]//font[@size=6]'
//                )));
//
//                $code = $mailDriver->findElement(WebDriverBy::xpath(
//                    '//*[@id="email_content_mailru_css_attribute_postfix"]//font[@size=6]'
//                ))->getText();
//
//                $mailDriver->quit();
//
//                sleep(2);
//
//                $driver->wait()->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector(
//                    '#security_code'
//                )));
//
//                $driver->findElement(WebDriverBy::cssSelector('#security_code'))->sendKeys($code);
//
//                $driver->findElement(WebDriverBy::xpath('//button[text() = \'Submit\']'))->click();
//
//                $driver
//                    ->wait()
//                    ->until(
//                        WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::xpath(
//                            '//a[contains(text(), "' . $login . '")]'
//                        ))
//                    );
//            }
//        }

        return new Instagram($webDriver);
    }
}