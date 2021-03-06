<?php

namespace spec\Firewall\Host;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IPSpec extends ObjectBehavior
{
    function it_is_initializable_from_a_string()
    {
        $this->beConstructedThrough('fromString', ['123.0.0.1']);
        $this->shouldHaveType('Firewall\Host\IP');
        $this->shouldImplement('Firewall\Host\Host');
        $this->shouldNotThrow('Firewall\Host\Exception\InvalidArgumentException')->duringInstantiation();
    }

    function it_is_initializable_from_the_current_request()
    {
        $this->beConstructedThrough('fromCurrentRequest', []);
        $this->shouldHaveType('Firewall\Host\IP');
        $this->shouldImplement('Firewall\Host\Host');
        $this->shouldNotThrow('Firewall\Host\Exception\InvalidArgumentException')->duringInstantiation();
    }

    function it_should_allow_ipv4_addresses()
    {
        $this->beConstructedThrough('fromString', ['123.0.0.1']);
        $this->shouldNotThrow('Firewall\Host\Exception\InvalidArgumentException')->duringInstantiation();
    }

    function it_should_allow_ipv6_addresses()
    {
        $this->beConstructedThrough('fromString', ['3ffe:6a88:85a3:08d3:1319:8a2e:0370:7344']);
        $this->shouldNotThrow('Firewall\Host\Exception\InvalidArgumentException')->duringInstantiation();
    }

    function it_should_not_allow_invalid_ip_addresses()
    {
        $this->beConstructedThrough('fromString', ['123..0.0.1']);
        $this->shouldThrow('Firewall\Host\Exception\InvalidArgumentException')->duringInstantiation();

        $this->beConstructedThrough('fromString', ['1200::AB00:1234::2552:7777:1313']);
        $this->shouldThrow('Firewall\Host\Exception\InvalidArgumentException')->duringInstantiation();

        $this->beConstructedThrough('fromString', ['not-an-ip.com']);
        $this->shouldThrow('Firewall\Host\Exception\InvalidArgumentException')->duringInstantiation();
    }

    function it_compares_equality_with_another_ip()
    {
        $this->beConstructedThrough('fromString', ['123.0.0.1']);

        $ip1 = $this::fromString('123.0.0.1');
        $this->equals($ip1)->shouldBe(true);

        $ip2 = $this::fromString('192.0.0.1');
        $this->equals($ip2)->shouldBe(false);
    }

    function it_converts_itself_to_a_string()
    {
        $this->beConstructedThrough('fromString', ['123.0.0.1']);
        $this->toString()->shouldBe('123.0.0.1');
    }
}
