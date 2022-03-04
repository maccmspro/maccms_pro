System Information Provider
================================
[![Build Status](https://travis-ci.org/trntv/probe.svg?branch=master)](https://travis-ci.org/trntv/probe)

This package provide an easy interface to get information about system it is running on.
```php
$provider = \Probe\ProviderFactory::create();
$provider->getCpuModel();
$provider->getCpuUsage();
$provider->getFreeMem();
```

## Available methods
- getOsRelease()
- getOsType();
- getOsKernelVersion();
- getArchitecture();
- getDbVersion(\PDO $connection);
- getDbInfo(\PDO $connection);
- getDbType(\PDO $connection);
- getTotalMem();
- getFreeMem();
- getUsedMem();
- getTotalSwap();
- getFreeSwap();
- getUsedSwap();
- getHostname();
- isLinuxOs();
- isWindowsOs();
- isBsdOs();
- isMacOs();
- getUptime();
- getPhysicalCpus();
- getCpuCores();
- getCpuPhysicalCore();
- getCpuModel();
- getCpuUsage();
- getServerIP();
- getExternalIP();
- getServerSoftware();
- isISS();
- isNginx();
- isApache();
- getPhpInfo($what = -1);
- getPhpVersion();
- getPhpDisabledFunctions();
- getPhpModules();
- isPhpModuleLoaded($module);
- getPing(array $hosts = null, $count = 2);
- getServerVariable($key);
- getPhpSapiName();
- isFpm();
- isCli();

## Supported OS
- Linux
- Windows
- MacOS

**Note**: To get Windows System Information, you hould have `php_com_dotnet.dll` enabled in your `php.ini`.
```php
[COM_DOT_NET] 
extension=php_com_dotnet.dll
```

## Linux Specific methods
- getCoresPerSocket()
- getCpuinfoByLsCpu()

## Contributing
I don't have any special rules for it. Any help in any way will be useful.

## TODO
- disk usage
- rx/tx
- processes list
