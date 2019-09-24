EasyLogHandler (human-friendly log files)
=========================================

Symfony log files are formatted in the same way for all environments. This means that `dev.log` is optimized for machines instead of humans. The result is a log file bloated with useless information that makes you less productive.

**EasyLogHandler** is a new Monolog handler that creates human-friendly log files. It's optimized to display the log information in a clear and concise way. Use it in the development environment to become a much more productive developer.

1. [Features](#features)
2. [Installation](#installation)
3. [Configuration and Usage](#configuration-and-usage)

----

Features
--------

These are some of the best features of **EasyLogHandler** and how it compares itself with the default Symfony logs.

### Better Log Structure

Symfony log files are a huge stream of text. When you open them, you can't easily tell when a request started or finished and which log messages belong together:

| Symfony | EasyLogHandler
| ------- | --------------
| ![structure-overview-symfony-mini](https://cloud.githubusercontent.com/assets/73419/17691467/e838b0b2-6394-11e6-9028-bfa04adc36c1.png) | ![structure-overview-easylog-mini](https://cloud.githubusercontent.com/assets/73419/17691466/e8336c88-6394-11e6-9a13-32146e2bdb6f.png)

EasyLogHandler structures the log files in a different way:

![structure-easylog](https://cloud.githubusercontent.com/assets/73419/17691552/788c4138-6395-11e6-8436-36051a4eb0da.png)

* It adds a large header and some new lines to separate each request logs;
* If the request is less significant (e.g. Assetic requests) the header is more compact and displays less information;
* Log messages are divided internally so you can better understand their different parts (request, doctrine, security, etc.)

### Less Verbose Logs

First of all, EasyLogHandler doesn't display the timestamp in every log message. In the `dev` environment you shouldn't care about that, so the timestamp is only displayed once for each group of log messages.

| Symfony | EasyLogHandler
| ------- | --------------
| ![timestamps-symfony](https://cloud.githubusercontent.com/assets/73419/17691577/9f0bce78-6395-11e6-8e6b-f2ae3354342b.png) | ![timestamps-easylog](https://cloud.githubusercontent.com/assets/73419/17691578/9f4ceed0-6395-11e6-96ea-aada7577e1b2.png)

The `extra` information, which some log messages include to add more details about the log, is displayed only when it's different from the previous log. In contrast, Symfony always displays the `extra` for all logs, generating a lot of duplicated information:

| Symfony
| -------
| ![extra-symfony](https://cloud.githubusercontent.com/assets/73419/17691601/c17f2996-6395-11e6-876b-fbd87422c04d.png)

| EasyLogHandler
| -------
| ![extra-easylog](https://cloud.githubusercontent.com/assets/73419/17691600/c13fe75e-6395-11e6-92db-bb8457967642.png)

It's becoming increasingly popular to use placeholders in log messages instead of the actual values (e.g. `Matched route "{route}".` instead of `Matched route "home".`) This is great for machines, because they can group similar messages that only vary in the placeholder values.

However, for humans this "feature" is disturbing. That's why EasyLogHandler automatically replaces any placeholder included in the log message:

| Symfony
| -------
| ![placeholders-symfony](https://cloud.githubusercontent.com/assets/73419/17691694/541e4a20-6396-11e6-8400-546383a69755.png)

| EasyLogHandler
| --------------
| ![placeholder-easylog](https://cloud.githubusercontent.com/assets/73419/17691695/545b2f9e-6396-11e6-9b46-814c6dcde9e0.png)

### Better Visual Hierarchy

Important elements, such as deprecations and security-related messages, must stand out in log files to help you spot them instantly. However, in Symfony all logs look exactly the same. How can you know which are the important ones?

| Symfony
| -------
| ![visual-hierarchy-symfony](https://cloud.githubusercontent.com/assets/73419/17691756/a0164edc-6396-11e6-949a-73e973219d13.png) <br> (all messages look exactly the same)

| EasyLogHandler
| --------------
| ![visual-hierarchy-easylog](https://cloud.githubusercontent.com/assets/73419/17691755/9fe3b86e-6396-11e6-9308-abaeb8c5b823.png) <br> (deprecations, warnings, errors and security messages stand out)

### Dynamic Variable Inlining

Log messages usually contain related variables in their `context` and `extra` properties. Displaying the content of these variables in the log files is always a tough balance between readability and conciseness.

EasyLogHandler decides how to inline these variables dynamically depending on each log message. For example, Doctrine query parameters are always inlined but request parameters are inlined for unimportant requests and nested for important requests:

![dynamic-inline-easylog](https://cloud.githubusercontent.com/assets/73419/17691843/2fde6324-6397-11e6-8627-e7c04528c6b3.png)

### Stack Traces

When log messages include error stack traces, you definitely want to take a look at them. However, Symfony displays stack traces inlined, making them impossible to inspect. EasyLogHandler displays them as proper stack traces:

| Symfony
| -------
| ![stack-trace-symfony](https://cloud.githubusercontent.com/assets/73419/17691905/716839d2-6397-11e6-8d45-b8be84ad9596.png)

| EasyLogHandler
| --------------
| ![stack-trace-easylog](https://cloud.githubusercontent.com/assets/73419/17691908/72190302-6397-11e6-95c0-8c9c0b570d97.png)

### Log Message Grouping

One of the most frustrating experiences when inspecting log files is having lots of repeated or similar consecutive messages. They provide little information and they just distract you. EasyLogHandler process all log messages at once instead of one by one, so it's aware when there are similar consecutive logs.

For example, this is a Symfony log file displaying three consecutive missing translation messages:

![translation-group-symfony](https://cloud.githubusercontent.com/assets/73419/17691954/b76ef04c-6397-11e6-9127-675ae831fd31.png)

And this is how the same messages are displayed by EasyLogHandler:

![translation-group-easylog](https://cloud.githubusercontent.com/assets/73419/17691955/b895ca86-6397-11e6-83c8-e5d6da4dbdf3.png)

The difference is even more evident for "event notified" messages, which usually generate tens of consecutive messages:

| Symfony
| -------
| ![event-group-symfony](https://cloud.githubusercontent.com/assets/73419/17691951/b447634a-6397-11e6-8482-265d7b02ead6.png)

| EasyLogHandler
| --------------
| ![event-group-easylog](https://cloud.githubusercontent.com/assets/73419/17691952/b5f5fd96-6397-11e6-8fc6-8835e6be7824.png)

Installation
------------

This project is distributed as a PHP package instead of a Symfony bundle, so you just need to require the project with [Composer](https://getcomposer.org):

```bash
$ composer require easycorp/easy-log-handler
```

Configuration and Usage
-----------------------

### Step 1

Define a new service in your application for this log handler:

```yaml
# app/config/services.yml
services:
    # ...
    easycorp.easylog.handler:
        class: EasyCorp\EasyLog\EasyLogHandler
        public: false
        arguments:
            - '%kernel.logs_dir%/%kernel.environment%.log'
```

### Step 2

Update your Monolog configuration in the `dev` environment to define a buffered handler that wraps this new handler service (keep reading to understand why). You can safely copy+paste this configuration:

```yaml
# app/config/config_dev.yml
monolog:
    handlers:
        buffered:
            type:     buffer
            handler:  easylog
            channels: ["!event"]
            level:    debug
        easylog:
            type: service
            id:   easycorp.easylog.handler
```

Most log handlers treat each log message separately. In contrast, EasyLogHandler advanced log processing requires each log message to be aware of the other logs (for example to merge similar consecutive messages). This means that all the logs associated with the request must be captured and processed in batch.

In the above configuration, the `buffered` handler saves all log messages and then passes them to the EasyLog handler, which processes all messages at once and writes the result in the log file.

Use the `buffered` handler to configure the channels logged/excluded and the level of the messages being logged.
