<?php

return <<<TEMPLATE
        [[ id ]]:
            name: [[ name ]]
            enabled: [[ status ]]
            deleted: [[ delete_status ]]

            # [SMTP] Outgoing mail server
            # Swiftmailer smtp mailer to use for sending emails through on behalf of this mailbox
            smtp_server: 
                mailer_id: [[ swiftmailer_id ]]

            # [IMAP] Incoming mail server
            # IMAP configurations to use for fetching emails from mailbox
            imap_server:
                host: '[[ imap_host ]]'
                username: [[ imap_username ]]
                password: [[ imap_password ]]


TEMPLATE;

?>