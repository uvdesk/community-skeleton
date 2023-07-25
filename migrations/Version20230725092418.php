<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230725092418 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE agent_activity (id INT AUTO_INCREMENT NOT NULL, agent_id INT NOT NULL, ticket_id INT NOT NULL, agent_name VARCHAR(255) DEFAULT NULL, customer_name VARCHAR(255) DEFAULT NULL, thread_type VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_9AA510CE3414710B (agent_id), INDEX IDX_9AA510CE700047D2 (ticket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE announcement (id INT AUTO_INCREMENT NOT NULL, group_id INT NOT NULL, title VARCHAR(255) NOT NULL, promo_text VARCHAR(255) NOT NULL, promo_tag VARCHAR(255) NOT NULL, tag_color VARCHAR(255) DEFAULT NULL, link_text VARCHAR(255) NOT NULL, link_url VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_4DB9D91CFE54D947 (group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recaptcha (id INT AUTO_INCREMENT NOT NULL, site_key VARCHAR(255) DEFAULT NULL, secret_key VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_api_access_credentials (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, created_on DATETIME NOT NULL, is_enabled TINYINT(1) DEFAULT \'1\' NOT NULL, is_expired TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_31DBD20EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_article (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, content LONGTEXT NOT NULL, meta_description TEXT DEFAULT NULL, keywords VARCHAR(255) DEFAULT NULL, viewed INT DEFAULT NULL, status INT DEFAULT 0, date_added DATETIME NOT NULL, date_updated DATETIME NOT NULL, stared INT DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL, INDEX search_idx (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_article_category (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_article_feedback (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, user_id INT DEFAULT NULL, is_helpful TINYINT(1) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_BCB7F9147294869C (article_id), INDEX IDX_BCB7F914A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_article_history (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, user_id INT NOT NULL, content LONGTEXT NOT NULL, date_added DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_article_tags (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_article_view_log (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, article_id INT DEFAULT NULL, viewed_at DATETIME NOT NULL, INDEX IDX_8F76FF11A76ED395 (user_id), INDEX IDX_8F76FF117294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_email_templates (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(191) NOT NULL, subject VARCHAR(191) NOT NULL, message LONGTEXT NOT NULL, template_type VARCHAR(255) DEFAULT NULL, is_predefined TINYINT(1) DEFAULT \'1\' NOT NULL, INDEX IDX_784A0D85A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_prepared_responses (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, type VARCHAR(255) DEFAULT \'public\', actions LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', status TINYINT(1) DEFAULT \'1\', date_added DATETIME NOT NULL, date_updated DATETIME NOT NULL, INDEX IDX_8AB5F066A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_prepared_response_support_groups (group_id INT NOT NULL, savedReply_id INT NOT NULL, INDEX IDX_A22590198D3102C3 (savedReply_id), INDEX IDX_A2259019FE54D947 (group_id), PRIMARY KEY(savedReply_id, group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_prepared_response_support_teams (subgroup_id INT NOT NULL, savedReply_id INT NOT NULL, INDEX IDX_B6897DEB8D3102C3 (savedReply_id), INDEX IDX_B6897DEBF5C464CE (subgroup_id), PRIMARY KEY(savedReply_id, subgroup_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_related_articles (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, related_article_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_saved_filters (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(191) NOT NULL, filtering LONGTEXT DEFAULT NULL, route VARCHAR(190) DEFAULT NULL, date_added DATETIME NOT NULL, date_updated DATETIME NOT NULL, INDEX IDX_E1BFBAF7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_saved_replies (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, subject VARCHAR(255) DEFAULT NULL, message LONGTEXT NOT NULL, template_id INT DEFAULT NULL, is_predefind TINYINT(1) DEFAULT \'1\', message_inline LONGTEXT DEFAULT NULL, template_for VARCHAR(255) DEFAULT NULL, INDEX IDX_39C8BA50A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_saved_replies_groups (group_id INT NOT NULL, savedReply_id INT NOT NULL, INDEX IDX_C59C13668D3102C3 (savedReply_id), INDEX IDX_C59C1366FE54D947 (group_id), PRIMARY KEY(savedReply_id, group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_saved_replies_teams (subgroup_id INT NOT NULL, savedReply_id INT NOT NULL, INDEX IDX_D240CE708D3102C3 (savedReply_id), INDEX IDX_D240CE70F5C464CE (subgroup_id), PRIMARY KEY(savedReply_id, subgroup_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_solution_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(100) DEFAULT NULL, sort_order INT DEFAULT 1, sorting VARCHAR(255) DEFAULT \'ascending\', date_added DATETIME NOT NULL, status INT DEFAULT 0, date_updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_solution_category_mapping (id INT AUTO_INCREMENT NOT NULL, solution_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_solutions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, visibility VARCHAR(255) NOT NULL, sort_order INT DEFAULT 5 NOT NULL, date_added DATETIME NOT NULL, date_updated DATETIME NOT NULL, solution_image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_support_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, is_active TINYINT(1) DEFAULT \'0\' NOT NULL, user_view TINYINT(1) DEFAULT \'0\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_support_groups_teams (supportGroup_id INT NOT NULL, supportTeam_id INT NOT NULL, INDEX IDX_761A315DCE5F5290 (supportGroup_id), INDEX IDX_761A315D9718E641 (supportTeam_id), PRIMARY KEY(supportGroup_id, supportTeam_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_support_label (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(191) NOT NULL, color_code VARCHAR(191) DEFAULT NULL, INDEX IDX_EFD454DDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_support_privilege (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) NOT NULL, description LONGTEXT NOT NULL, privileges LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_support_role (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(191) NOT NULL, description VARCHAR(191) DEFAULT NULL, UNIQUE INDEX UNIQ_2AF5A72177153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_support_team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, is_active TINYINT(1) DEFAULT \'0\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_thread (id INT AUTO_INCREMENT NOT NULL, ticket_id INT DEFAULT NULL, user_id INT DEFAULT NULL, source VARCHAR(191) NOT NULL, message_id LONGTEXT DEFAULT NULL, thread_type VARCHAR(191) NOT NULL, created_by VARCHAR(191) NOT NULL, cc LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', bcc LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', reply_to LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', delivery_status VARCHAR(255) DEFAULT NULL, is_locked TINYINT(1) DEFAULT \'0\' NOT NULL, is_bookmarked TINYINT(1) DEFAULT \'0\' NOT NULL, message LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, agent_viewed_at DATETIME DEFAULT NULL, customer_viewed_at DATETIME DEFAULT NULL, INDEX IDX_637D7E5D700047D2 (ticket_id), INDEX IDX_637D7E5DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_ticket (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, priority_id INT DEFAULT NULL, type_id INT DEFAULT NULL, customer_id INT DEFAULT NULL, agent_id INT DEFAULT NULL, group_id INT DEFAULT NULL, source VARCHAR(191) NOT NULL, mailbox_email VARCHAR(191) DEFAULT NULL, subject LONGTEXT DEFAULT NULL, reference_ids LONGTEXT DEFAULT NULL, is_new TINYINT(1) DEFAULT \'1\' NOT NULL, is_replied TINYINT(1) DEFAULT \'0\' NOT NULL, is_reply_enabled TINYINT(1) DEFAULT \'1\' NOT NULL, is_starred TINYINT(1) DEFAULT \'0\' NOT NULL, is_trashed TINYINT(1) DEFAULT \'0\' NOT NULL, is_agent_viewed TINYINT(1) DEFAULT \'0\' NOT NULL, is_customer_viewed TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, subGroup_id INT DEFAULT NULL, INDEX IDX_C5FD9F7D6BF700BD (status_id), INDEX IDX_C5FD9F7D497B19F9 (priority_id), INDEX IDX_C5FD9F7DC54C8C93 (type_id), INDEX IDX_C5FD9F7D9395C3F3 (customer_id), INDEX IDX_C5FD9F7D3414710B (agent_id), INDEX IDX_C5FD9F7DFE54D947 (group_id), INDEX IDX_C5FD9F7DCB20698 (subGroup_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_tickets_collaborators (ticket_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_20764CBA700047D2 (ticket_id), INDEX IDX_20764CBAA76ED395 (user_id), PRIMARY KEY(ticket_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_tickets_tags (ticket_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_CF4DF9E3700047D2 (ticket_id), INDEX IDX_CF4DF9E3BAD26311 (tag_id), PRIMARY KEY(ticket_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_tickets_labels (ticket_id INT NOT NULL, label_id INT NOT NULL, INDEX IDX_305F9C0E700047D2 (ticket_id), INDEX IDX_305F9C0E33B92F39 (label_id), PRIMARY KEY(ticket_id, label_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_ticket_attachments (id INT AUTO_INCREMENT NOT NULL, thread_id INT DEFAULT NULL, name LONGTEXT DEFAULT NULL, path LONGTEXT DEFAULT NULL, content_type VARCHAR(255) DEFAULT NULL, size INT DEFAULT NULL, content_id VARCHAR(255) DEFAULT NULL, file_system VARCHAR(255) DEFAULT NULL, INDEX IDX_FE918C8EE2904019 (thread_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_ticket_priority (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(191) NOT NULL, description LONGTEXT DEFAULT NULL, color_code VARCHAR(191) DEFAULT NULL, UNIQUE INDEX UNIQ_FFA6CF8677153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_ticket_rating (id INT AUTO_INCREMENT NOT NULL, ticket_id INT DEFAULT NULL, user_id INT DEFAULT NULL, stars INT DEFAULT 0 NOT NULL, feedback LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_B1025E04700047D2 (ticket_id), INDEX IDX_B1025E04A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_ticket_status (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(191) NOT NULL, description LONGTEXT DEFAULT NULL, color_code VARCHAR(191) DEFAULT NULL, sort_order INT DEFAULT NULL, UNIQUE INDEX UNIQ_128B1D3A77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_ticket_type (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(191) NOT NULL, description LONGTEXT DEFAULT NULL, is_active TINYINT(1) DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_3E0B313677153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(191) DEFAULT NULL, proxy_id VARCHAR(191) DEFAULT NULL, password VARCHAR(191) DEFAULT NULL, first_name VARCHAR(191) NOT NULL, last_name VARCHAR(191) DEFAULT NULL, is_enabled TINYINT(1) DEFAULT \'0\' NOT NULL, verification_code VARCHAR(191) DEFAULT NULL, timezone VARCHAR(191) DEFAULT NULL, timeformat VARCHAR(191) DEFAULT NULL, UNIQUE INDEX UNIQ_E8D39F61E7927C74 (email), UNIQUE INDEX UNIQ_E8D39F61DB26A4E (proxy_id), UNIQUE INDEX UNIQ_E8D39F61E821C39F (verification_code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_user_instance (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, source VARCHAR(191) NOT NULL, skype_id VARCHAR(191) DEFAULT NULL, contact_number VARCHAR(191) DEFAULT NULL, designation VARCHAR(191) DEFAULT NULL, signature LONGTEXT DEFAULT NULL, profile_image_path LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_active TINYINT(1) DEFAULT \'0\' NOT NULL, is_verified TINYINT(1) DEFAULT \'0\' NOT NULL, is_starred TINYINT(1) DEFAULT \'0\' NOT NULL, ticket_access_level VARCHAR(32) DEFAULT NULL, supportRole_id INT DEFAULT NULL, INDEX IDX_B1744733A76ED395 (user_id), INDEX IDX_B174473368771C43 (supportRole_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_user_support_privileges (userInstanceId INT NOT NULL, supportPrivilegeId INT NOT NULL, INDEX IDX_9550EDB28B414560 (userInstanceId), INDEX IDX_9550EDB289C60B89 (supportPrivilegeId), PRIMARY KEY(userInstanceId, supportPrivilegeId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_user_support_teams (userInstanceId INT NOT NULL, supportTeamId INT NOT NULL, INDEX IDX_5F33E9F78B414560 (userInstanceId), INDEX IDX_5F33E9F7A77C7023 (supportTeamId), PRIMARY KEY(userInstanceId, supportTeamId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_user_support_groups (userInstanceId INT NOT NULL, supportGroupId INT NOT NULL, INDEX IDX_B6CD76C28B414560 (userInstanceId), INDEX IDX_B6CD76C253F5B65F (supportGroupId), PRIMARY KEY(userInstanceId, supportGroupId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_lead_support_teams (leadUserInstanceId INT NOT NULL, supportTeamId INT NOT NULL, INDEX IDX_8B5F844DD397BD7C (leadUserInstanceId), INDEX IDX_8B5F844DA77C7023 (supportTeamId), PRIMARY KEY(leadUserInstanceId, supportTeamId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_admin_support_groups (adminUserInstanceId INT NOT NULL, supportGroupId INT NOT NULL, INDEX IDX_215FF93837B7A2F1 (adminUserInstanceId), INDEX IDX_215FF93853F5B65F (supportGroupId), PRIMARY KEY(adminUserInstanceId, supportGroupId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_website (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) NOT NULL, code VARCHAR(191) NOT NULL, logo VARCHAR(191) DEFAULT NULL, theme_color VARCHAR(191) NOT NULL, favicon VARCHAR(191) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_active TINYINT(1) DEFAULT \'1\', timezone VARCHAR(191) DEFAULT NULL, timeformat VARCHAR(191) DEFAULT NULL, UNIQUE INDEX UNIQ_2656FF0677153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_website_knowledgebase (id INT AUTO_INCREMENT NOT NULL, website INT DEFAULT NULL, status VARCHAR(255) NOT NULL, brand_color VARCHAR(255) NOT NULL, page_background_color VARCHAR(255) NOT NULL, header_background_color VARCHAR(255) DEFAULT NULL, link_color VARCHAR(255) DEFAULT NULL, article_text_color VARCHAR(255) DEFAULT NULL, ticket_create_option VARCHAR(255) NOT NULL, site_description VARCHAR(1000) DEFAULT NULL, meta_description TEXT DEFAULT NULL, meta_keywords TEXT DEFAULT NULL, homepage_content VARCHAR(255) DEFAULT NULL, white_list LONGTEXT DEFAULT NULL, black_list LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, broadcast_message LONGTEXT DEFAULT NULL, disable_customer_login TINYINT(1) NOT NULL, script LONGTEXT DEFAULT NULL, custom_css LONGTEXT DEFAULT NULL, is_active TINYINT(1) NOT NULL, header_links LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', footer_links LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', banner_background_color VARCHAR(255) DEFAULT NULL, link_hover_color VARCHAR(255) DEFAULT NULL, login_required_to_create TINYINT(1) DEFAULT NULL, remove_customer_login_button INT DEFAULT 0, remove_branding_content INT DEFAULT 0, INDEX IDX_DFF10F0B476F5DE7 (website), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_workflow (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) NOT NULL, description LONGTEXT DEFAULT NULL, conditions LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', actions LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', sort_order INT DEFAULT NULL, is_predefind TINYINT(1) DEFAULT \'1\' NOT NULL, status TINYINT(1) DEFAULT \'1\' NOT NULL, date_added DATETIME NOT NULL, date_updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uv_workflow_events (id INT AUTO_INCREMENT NOT NULL, workflow_id INT DEFAULT NULL, event_id INT NOT NULL, event VARCHAR(191) NOT NULL, INDEX IDX_6AEB02A92C7C2CBA (workflow_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agent_activity ADD CONSTRAINT FK_9AA510CE3414710B FOREIGN KEY (agent_id) REFERENCES uv_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agent_activity ADD CONSTRAINT FK_9AA510CE700047D2 FOREIGN KEY (ticket_id) REFERENCES uv_ticket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91CFE54D947 FOREIGN KEY (group_id) REFERENCES uv_support_group (id)');
        $this->addSql('ALTER TABLE uv_api_access_credentials ADD CONSTRAINT FK_31DBD20EA76ED395 FOREIGN KEY (user_id) REFERENCES uv_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_article_feedback ADD CONSTRAINT FK_BCB7F9147294869C FOREIGN KEY (article_id) REFERENCES uv_article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_article_feedback ADD CONSTRAINT FK_BCB7F914A76ED395 FOREIGN KEY (user_id) REFERENCES uv_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_article_view_log ADD CONSTRAINT FK_8F76FF11A76ED395 FOREIGN KEY (user_id) REFERENCES uv_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_article_view_log ADD CONSTRAINT FK_8F76FF117294869C FOREIGN KEY (article_id) REFERENCES uv_article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_email_templates ADD CONSTRAINT FK_784A0D85A76ED395 FOREIGN KEY (user_id) REFERENCES uv_user_instance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_prepared_responses ADD CONSTRAINT FK_8AB5F066A76ED395 FOREIGN KEY (user_id) REFERENCES uv_user_instance (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE uv_prepared_response_support_groups ADD CONSTRAINT FK_A22590198D3102C3 FOREIGN KEY (savedReply_id) REFERENCES uv_prepared_responses (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_prepared_response_support_groups ADD CONSTRAINT FK_A2259019FE54D947 FOREIGN KEY (group_id) REFERENCES uv_support_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_prepared_response_support_teams ADD CONSTRAINT FK_B6897DEB8D3102C3 FOREIGN KEY (savedReply_id) REFERENCES uv_prepared_responses (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_prepared_response_support_teams ADD CONSTRAINT FK_B6897DEBF5C464CE FOREIGN KEY (subgroup_id) REFERENCES uv_support_team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_saved_filters ADD CONSTRAINT FK_E1BFBAF7A76ED395 FOREIGN KEY (user_id) REFERENCES uv_user_instance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_saved_replies ADD CONSTRAINT FK_39C8BA50A76ED395 FOREIGN KEY (user_id) REFERENCES uv_user_instance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_saved_replies_groups ADD CONSTRAINT FK_C59C13668D3102C3 FOREIGN KEY (savedReply_id) REFERENCES uv_saved_replies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_saved_replies_groups ADD CONSTRAINT FK_C59C1366FE54D947 FOREIGN KEY (group_id) REFERENCES uv_support_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_saved_replies_teams ADD CONSTRAINT FK_D240CE708D3102C3 FOREIGN KEY (savedReply_id) REFERENCES uv_saved_replies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_saved_replies_teams ADD CONSTRAINT FK_D240CE70F5C464CE FOREIGN KEY (subgroup_id) REFERENCES uv_support_team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_support_groups_teams ADD CONSTRAINT FK_761A315DCE5F5290 FOREIGN KEY (supportGroup_id) REFERENCES uv_support_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_support_groups_teams ADD CONSTRAINT FK_761A315D9718E641 FOREIGN KEY (supportTeam_id) REFERENCES uv_support_team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_support_label ADD CONSTRAINT FK_EFD454DDA76ED395 FOREIGN KEY (user_id) REFERENCES uv_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_thread ADD CONSTRAINT FK_637D7E5D700047D2 FOREIGN KEY (ticket_id) REFERENCES uv_ticket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_thread ADD CONSTRAINT FK_637D7E5DA76ED395 FOREIGN KEY (user_id) REFERENCES uv_user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE uv_ticket ADD CONSTRAINT FK_C5FD9F7D6BF700BD FOREIGN KEY (status_id) REFERENCES uv_ticket_status (id)');
        $this->addSql('ALTER TABLE uv_ticket ADD CONSTRAINT FK_C5FD9F7D497B19F9 FOREIGN KEY (priority_id) REFERENCES uv_ticket_priority (id)');
        $this->addSql('ALTER TABLE uv_ticket ADD CONSTRAINT FK_C5FD9F7DC54C8C93 FOREIGN KEY (type_id) REFERENCES uv_ticket_type (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE uv_ticket ADD CONSTRAINT FK_C5FD9F7D9395C3F3 FOREIGN KEY (customer_id) REFERENCES uv_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_ticket ADD CONSTRAINT FK_C5FD9F7D3414710B FOREIGN KEY (agent_id) REFERENCES uv_user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE uv_ticket ADD CONSTRAINT FK_C5FD9F7DFE54D947 FOREIGN KEY (group_id) REFERENCES uv_support_group (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE uv_ticket ADD CONSTRAINT FK_C5FD9F7DCB20698 FOREIGN KEY (subGroup_id) REFERENCES uv_support_team (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE uv_tickets_collaborators ADD CONSTRAINT FK_20764CBA700047D2 FOREIGN KEY (ticket_id) REFERENCES uv_ticket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_tickets_collaborators ADD CONSTRAINT FK_20764CBAA76ED395 FOREIGN KEY (user_id) REFERENCES uv_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_tickets_tags ADD CONSTRAINT FK_CF4DF9E3700047D2 FOREIGN KEY (ticket_id) REFERENCES uv_ticket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_tickets_tags ADD CONSTRAINT FK_CF4DF9E3BAD26311 FOREIGN KEY (tag_id) REFERENCES uv_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_tickets_labels ADD CONSTRAINT FK_305F9C0E700047D2 FOREIGN KEY (ticket_id) REFERENCES uv_ticket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_tickets_labels ADD CONSTRAINT FK_305F9C0E33B92F39 FOREIGN KEY (label_id) REFERENCES uv_support_label (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_ticket_attachments ADD CONSTRAINT FK_FE918C8EE2904019 FOREIGN KEY (thread_id) REFERENCES uv_thread (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_ticket_rating ADD CONSTRAINT FK_B1025E04700047D2 FOREIGN KEY (ticket_id) REFERENCES uv_ticket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_ticket_rating ADD CONSTRAINT FK_B1025E04A76ED395 FOREIGN KEY (user_id) REFERENCES uv_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_user_instance ADD CONSTRAINT FK_B1744733A76ED395 FOREIGN KEY (user_id) REFERENCES uv_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_user_instance ADD CONSTRAINT FK_B174473368771C43 FOREIGN KEY (supportRole_id) REFERENCES uv_support_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_user_support_privileges ADD CONSTRAINT FK_9550EDB28B414560 FOREIGN KEY (userInstanceId) REFERENCES uv_user_instance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_user_support_privileges ADD CONSTRAINT FK_9550EDB289C60B89 FOREIGN KEY (supportPrivilegeId) REFERENCES uv_support_privilege (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_user_support_teams ADD CONSTRAINT FK_5F33E9F78B414560 FOREIGN KEY (userInstanceId) REFERENCES uv_user_instance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_user_support_teams ADD CONSTRAINT FK_5F33E9F7A77C7023 FOREIGN KEY (supportTeamId) REFERENCES uv_support_team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_user_support_groups ADD CONSTRAINT FK_B6CD76C28B414560 FOREIGN KEY (userInstanceId) REFERENCES uv_user_instance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_user_support_groups ADD CONSTRAINT FK_B6CD76C253F5B65F FOREIGN KEY (supportGroupId) REFERENCES uv_support_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_lead_support_teams ADD CONSTRAINT FK_8B5F844DD397BD7C FOREIGN KEY (leadUserInstanceId) REFERENCES uv_user_instance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_lead_support_teams ADD CONSTRAINT FK_8B5F844DA77C7023 FOREIGN KEY (supportTeamId) REFERENCES uv_support_team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_admin_support_groups ADD CONSTRAINT FK_215FF93837B7A2F1 FOREIGN KEY (adminUserInstanceId) REFERENCES uv_user_instance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_admin_support_groups ADD CONSTRAINT FK_215FF93853F5B65F FOREIGN KEY (supportGroupId) REFERENCES uv_support_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uv_website_knowledgebase ADD CONSTRAINT FK_DFF10F0B476F5DE7 FOREIGN KEY (website) REFERENCES uv_website (id)');
        $this->addSql('ALTER TABLE uv_workflow_events ADD CONSTRAINT FK_6AEB02A92C7C2CBA FOREIGN KEY (workflow_id) REFERENCES uv_workflow (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE uv_article_feedback DROP FOREIGN KEY FK_BCB7F9147294869C');
        $this->addSql('ALTER TABLE uv_article_view_log DROP FOREIGN KEY FK_8F76FF117294869C');
        $this->addSql('ALTER TABLE uv_prepared_response_support_groups DROP FOREIGN KEY FK_A22590198D3102C3');
        $this->addSql('ALTER TABLE uv_prepared_response_support_teams DROP FOREIGN KEY FK_B6897DEB8D3102C3');
        $this->addSql('ALTER TABLE uv_saved_replies_groups DROP FOREIGN KEY FK_C59C13668D3102C3');
        $this->addSql('ALTER TABLE uv_saved_replies_teams DROP FOREIGN KEY FK_D240CE708D3102C3');
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91CFE54D947');
        $this->addSql('ALTER TABLE uv_prepared_response_support_groups DROP FOREIGN KEY FK_A2259019FE54D947');
        $this->addSql('ALTER TABLE uv_saved_replies_groups DROP FOREIGN KEY FK_C59C1366FE54D947');
        $this->addSql('ALTER TABLE uv_support_groups_teams DROP FOREIGN KEY FK_761A315DCE5F5290');
        $this->addSql('ALTER TABLE uv_ticket DROP FOREIGN KEY FK_C5FD9F7DFE54D947');
        $this->addSql('ALTER TABLE uv_user_support_groups DROP FOREIGN KEY FK_B6CD76C253F5B65F');
        $this->addSql('ALTER TABLE uv_admin_support_groups DROP FOREIGN KEY FK_215FF93853F5B65F');
        $this->addSql('ALTER TABLE uv_tickets_labels DROP FOREIGN KEY FK_305F9C0E33B92F39');
        $this->addSql('ALTER TABLE uv_user_support_privileges DROP FOREIGN KEY FK_9550EDB289C60B89');
        $this->addSql('ALTER TABLE uv_user_instance DROP FOREIGN KEY FK_B174473368771C43');
        $this->addSql('ALTER TABLE uv_prepared_response_support_teams DROP FOREIGN KEY FK_B6897DEBF5C464CE');
        $this->addSql('ALTER TABLE uv_saved_replies_teams DROP FOREIGN KEY FK_D240CE70F5C464CE');
        $this->addSql('ALTER TABLE uv_support_groups_teams DROP FOREIGN KEY FK_761A315D9718E641');
        $this->addSql('ALTER TABLE uv_ticket DROP FOREIGN KEY FK_C5FD9F7DCB20698');
        $this->addSql('ALTER TABLE uv_user_support_teams DROP FOREIGN KEY FK_5F33E9F7A77C7023');
        $this->addSql('ALTER TABLE uv_lead_support_teams DROP FOREIGN KEY FK_8B5F844DA77C7023');
        $this->addSql('ALTER TABLE uv_tickets_tags DROP FOREIGN KEY FK_CF4DF9E3BAD26311');
        $this->addSql('ALTER TABLE uv_ticket_attachments DROP FOREIGN KEY FK_FE918C8EE2904019');
        $this->addSql('ALTER TABLE agent_activity DROP FOREIGN KEY FK_9AA510CE700047D2');
        $this->addSql('ALTER TABLE uv_thread DROP FOREIGN KEY FK_637D7E5D700047D2');
        $this->addSql('ALTER TABLE uv_tickets_collaborators DROP FOREIGN KEY FK_20764CBA700047D2');
        $this->addSql('ALTER TABLE uv_tickets_tags DROP FOREIGN KEY FK_CF4DF9E3700047D2');
        $this->addSql('ALTER TABLE uv_tickets_labels DROP FOREIGN KEY FK_305F9C0E700047D2');
        $this->addSql('ALTER TABLE uv_ticket_rating DROP FOREIGN KEY FK_B1025E04700047D2');
        $this->addSql('ALTER TABLE uv_ticket DROP FOREIGN KEY FK_C5FD9F7D497B19F9');
        $this->addSql('ALTER TABLE uv_ticket DROP FOREIGN KEY FK_C5FD9F7D6BF700BD');
        $this->addSql('ALTER TABLE uv_ticket DROP FOREIGN KEY FK_C5FD9F7DC54C8C93');
        $this->addSql('ALTER TABLE agent_activity DROP FOREIGN KEY FK_9AA510CE3414710B');
        $this->addSql('ALTER TABLE uv_api_access_credentials DROP FOREIGN KEY FK_31DBD20EA76ED395');
        $this->addSql('ALTER TABLE uv_article_feedback DROP FOREIGN KEY FK_BCB7F914A76ED395');
        $this->addSql('ALTER TABLE uv_article_view_log DROP FOREIGN KEY FK_8F76FF11A76ED395');
        $this->addSql('ALTER TABLE uv_support_label DROP FOREIGN KEY FK_EFD454DDA76ED395');
        $this->addSql('ALTER TABLE uv_thread DROP FOREIGN KEY FK_637D7E5DA76ED395');
        $this->addSql('ALTER TABLE uv_ticket DROP FOREIGN KEY FK_C5FD9F7D9395C3F3');
        $this->addSql('ALTER TABLE uv_ticket DROP FOREIGN KEY FK_C5FD9F7D3414710B');
        $this->addSql('ALTER TABLE uv_tickets_collaborators DROP FOREIGN KEY FK_20764CBAA76ED395');
        $this->addSql('ALTER TABLE uv_ticket_rating DROP FOREIGN KEY FK_B1025E04A76ED395');
        $this->addSql('ALTER TABLE uv_user_instance DROP FOREIGN KEY FK_B1744733A76ED395');
        $this->addSql('ALTER TABLE uv_email_templates DROP FOREIGN KEY FK_784A0D85A76ED395');
        $this->addSql('ALTER TABLE uv_prepared_responses DROP FOREIGN KEY FK_8AB5F066A76ED395');
        $this->addSql('ALTER TABLE uv_saved_filters DROP FOREIGN KEY FK_E1BFBAF7A76ED395');
        $this->addSql('ALTER TABLE uv_saved_replies DROP FOREIGN KEY FK_39C8BA50A76ED395');
        $this->addSql('ALTER TABLE uv_user_support_privileges DROP FOREIGN KEY FK_9550EDB28B414560');
        $this->addSql('ALTER TABLE uv_user_support_teams DROP FOREIGN KEY FK_5F33E9F78B414560');
        $this->addSql('ALTER TABLE uv_user_support_groups DROP FOREIGN KEY FK_B6CD76C28B414560');
        $this->addSql('ALTER TABLE uv_lead_support_teams DROP FOREIGN KEY FK_8B5F844DD397BD7C');
        $this->addSql('ALTER TABLE uv_admin_support_groups DROP FOREIGN KEY FK_215FF93837B7A2F1');
        $this->addSql('ALTER TABLE uv_website_knowledgebase DROP FOREIGN KEY FK_DFF10F0B476F5DE7');
        $this->addSql('ALTER TABLE uv_workflow_events DROP FOREIGN KEY FK_6AEB02A92C7C2CBA');
        $this->addSql('DROP TABLE agent_activity');
        $this->addSql('DROP TABLE announcement');
        $this->addSql('DROP TABLE recaptcha');
        $this->addSql('DROP TABLE uv_api_access_credentials');
        $this->addSql('DROP TABLE uv_article');
        $this->addSql('DROP TABLE uv_article_category');
        $this->addSql('DROP TABLE uv_article_feedback');
        $this->addSql('DROP TABLE uv_article_history');
        $this->addSql('DROP TABLE uv_article_tags');
        $this->addSql('DROP TABLE uv_article_view_log');
        $this->addSql('DROP TABLE uv_email_templates');
        $this->addSql('DROP TABLE uv_prepared_responses');
        $this->addSql('DROP TABLE uv_prepared_response_support_groups');
        $this->addSql('DROP TABLE uv_prepared_response_support_teams');
        $this->addSql('DROP TABLE uv_related_articles');
        $this->addSql('DROP TABLE uv_saved_filters');
        $this->addSql('DROP TABLE uv_saved_replies');
        $this->addSql('DROP TABLE uv_saved_replies_groups');
        $this->addSql('DROP TABLE uv_saved_replies_teams');
        $this->addSql('DROP TABLE uv_solution_category');
        $this->addSql('DROP TABLE uv_solution_category_mapping');
        $this->addSql('DROP TABLE uv_solutions');
        $this->addSql('DROP TABLE uv_support_group');
        $this->addSql('DROP TABLE uv_support_groups_teams');
        $this->addSql('DROP TABLE uv_support_label');
        $this->addSql('DROP TABLE uv_support_privilege');
        $this->addSql('DROP TABLE uv_support_role');
        $this->addSql('DROP TABLE uv_support_team');
        $this->addSql('DROP TABLE uv_tag');
        $this->addSql('DROP TABLE uv_thread');
        $this->addSql('DROP TABLE uv_ticket');
        $this->addSql('DROP TABLE uv_tickets_collaborators');
        $this->addSql('DROP TABLE uv_tickets_tags');
        $this->addSql('DROP TABLE uv_tickets_labels');
        $this->addSql('DROP TABLE uv_ticket_attachments');
        $this->addSql('DROP TABLE uv_ticket_priority');
        $this->addSql('DROP TABLE uv_ticket_rating');
        $this->addSql('DROP TABLE uv_ticket_status');
        $this->addSql('DROP TABLE uv_ticket_type');
        $this->addSql('DROP TABLE uv_user');
        $this->addSql('DROP TABLE uv_user_instance');
        $this->addSql('DROP TABLE uv_user_support_privileges');
        $this->addSql('DROP TABLE uv_user_support_teams');
        $this->addSql('DROP TABLE uv_user_support_groups');
        $this->addSql('DROP TABLE uv_lead_support_teams');
        $this->addSql('DROP TABLE uv_admin_support_groups');
        $this->addSql('DROP TABLE uv_website');
        $this->addSql('DROP TABLE uv_website_knowledgebase');
        $this->addSql('DROP TABLE uv_workflow');
        $this->addSql('DROP TABLE uv_workflow_events');
    }
}
