<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241129204410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE band (band_id INT AUTO_INCREMENT NOT NULL, music_style_id INT NOT NULL, band_name VARCHAR(100) NOT NULL, band_description VARCHAR(100) NOT NULL, band_image VARCHAR(255) NOT NULL, INDEX IDX_48DFA2EB7DDE3C52 (music_style_id), PRIMARY KEY(band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concert (concert_id INT AUTO_INCREMENT NOT NULL, band_id INT NOT NULL, stage_id INT NOT NULL, concert_date DATETIME NOT NULL, INDEX IDX_D57C02D249ABEB17 (band_id), INDEX IDX_D57C02D22298D193 (stage_id), PRIMARY KEY(concert_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faq_category (faq_category_id INT AUTO_INCREMENT NOT NULL, faq_category_name VARCHAR(100) NOT NULL, PRIMARY KEY(faq_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faq_content (faq_content_id INT AUTO_INCREMENT NOT NULL, faq_category_id INT NOT NULL, faq_content_title VARCHAR(100) NOT NULL, faq_content_details VARCHAR(500) NOT NULL, faq_content_update DATETIME NOT NULL, INDEX IDX_E5B45BF2F689B0DB (faq_category_id), PRIMARY KEY(faq_content_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE map_point (map_point_id INT AUTO_INCREMENT NOT NULL, map_point_category_id INT NOT NULL, longitude NUMERIC(10, 7) NOT NULL, latitude NUMERIC(10, 7) NOT NULL, map_point_title VARCHAR(100) NOT NULL, map_point_description VARCHAR(255) DEFAULT NULL, INDEX IDX_3753BC4837769206 (map_point_category_id), PRIMARY KEY(map_point_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE map_points_category (map_point_category_id INT AUTO_INCREMENT NOT NULL, map_point_category_name VARCHAR(50) NOT NULL, map_point_icon_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(map_point_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE music_style (music_style_id INT AUTO_INCREMENT NOT NULL, music_style_name VARCHAR(100) NOT NULL, PRIMARY KEY(music_style_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (news_id INT AUTO_INCREMENT NOT NULL, news_category_id INT NOT NULL, news_title VARCHAR(255) NOT NULL, news_content VARCHAR(600) NOT NULL, news_date DATETIME NOT NULL, INDEX IDX_1DD399503B732BAD (news_category_id), PRIMARY KEY(news_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_category (news_category_id INT AUTO_INCREMENT NOT NULL, news_category_name VARCHAR(100) NOT NULL, PRIMARY KEY(news_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partner (partner_id INT AUTO_INCREMENT NOT NULL, partner_category_id INT NOT NULL, partner_name VARCHAR(100) NOT NULL, partner_logo VARCHAR(255) DEFAULT NULL, partner_description VARCHAR(255) DEFAULT NULL, INDEX IDX_312B3E165B352BAC (partner_category_id), PRIMARY KEY(partner_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partner_category (partner_category_id INT AUTO_INCREMENT NOT NULL, partner_category_name VARCHAR(100) NOT NULL, PRIMARY KEY(partner_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stage (stage_id INT AUTO_INCREMENT NOT NULL, stage_name VARCHAR(100) NOT NULL, PRIMARY KEY(stage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE band ADD CONSTRAINT FK_48DFA2EB7DDE3C52 FOREIGN KEY (music_style_id) REFERENCES music_style (music_style_id)');
        $this->addSql('ALTER TABLE concert ADD CONSTRAINT FK_D57C02D249ABEB17 FOREIGN KEY (band_id) REFERENCES band (band_id)');
        $this->addSql('ALTER TABLE concert ADD CONSTRAINT FK_D57C02D22298D193 FOREIGN KEY (stage_id) REFERENCES stage (stage_id)');
        $this->addSql('ALTER TABLE faq_content ADD CONSTRAINT FK_E5B45BF2F689B0DB FOREIGN KEY (faq_category_id) REFERENCES faq_category (faq_category_id)');
        $this->addSql('ALTER TABLE map_point ADD CONSTRAINT FK_3753BC4837769206 FOREIGN KEY (map_point_category_id) REFERENCES map_points_category (map_point_category_id)');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD399503B732BAD FOREIGN KEY (news_category_id) REFERENCES news_category (news_category_id)');
        $this->addSql('ALTER TABLE partner ADD CONSTRAINT FK_312B3E165B352BAC FOREIGN KEY (partner_category_id) REFERENCES partner_category (partner_category_id)');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(100) NOT NULL, CHANGE last_name last_name VARCHAR(100) NOT NULL, CHANGE email_verification_token email_verification_token VARCHAR(100) DEFAULT NULL, CHANGE email_change_token email_change_token VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE band DROP FOREIGN KEY FK_48DFA2EB7DDE3C52');
        $this->addSql('ALTER TABLE concert DROP FOREIGN KEY FK_D57C02D249ABEB17');
        $this->addSql('ALTER TABLE concert DROP FOREIGN KEY FK_D57C02D22298D193');
        $this->addSql('ALTER TABLE faq_content DROP FOREIGN KEY FK_E5B45BF2F689B0DB');
        $this->addSql('ALTER TABLE map_point DROP FOREIGN KEY FK_3753BC4837769206');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD399503B732BAD');
        $this->addSql('ALTER TABLE partner DROP FOREIGN KEY FK_312B3E165B352BAC');
        $this->addSql('DROP TABLE band');
        $this->addSql('DROP TABLE concert');
        $this->addSql('DROP TABLE faq_category');
        $this->addSql('DROP TABLE faq_content');
        $this->addSql('DROP TABLE map_point');
        $this->addSql('DROP TABLE map_points_category');
        $this->addSql('DROP TABLE music_style');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE news_category');
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP TABLE partner_category');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE `user` CHANGE email email VARCHAR(180) NOT NULL, CHANGE last_name last_name VARCHAR(255) NOT NULL, CHANGE email_verification_token email_verification_token VARCHAR(255) DEFAULT NULL, CHANGE email_change_token email_change_token VARCHAR(255) DEFAULT NULL');
    }
}
