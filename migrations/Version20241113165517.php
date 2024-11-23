<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241113165517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE concert (id INT AUTO_INCREMENT NOT NULL, band_id INT NOT NULL, stage_id INT NOT NULL, concert_date DATETIME NOT NULL, INDEX IDX_D57C02D249ABEB17 (band_id), INDEX IDX_D57C02D22298D193 (stage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faq_content (id INT AUTO_INCREMENT NOT NULL, section_id INT NOT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(500) NOT NULL, content_update DATETIME NOT NULL, INDEX IDX_E5B45BF2D823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE map_point (map_point_id INT AUTO_INCREMENT NOT NULL, map_point_category_id INT NOT NULL, longitude NUMERIC(10, 7) NOT NULL, latitude NUMERIC(10, 7) NOT NULL, map_point_title VARCHAR(100) NOT NULL, map_point_description VARCHAR(255) DEFAULT NULL, INDEX IDX_3753BC4837769206 (map_point_category_id), PRIMARY KEY(map_point_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE map_points_category (map_point_category_id INT AUTO_INCREMENT NOT NULL, map_point_category VARCHAR(100) NOT NULL, map_point_icon_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(map_point_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE music_style (music_style_id INT AUTO_INCREMENT NOT NULL, music_style_name VARCHAR(255) NOT NULL, PRIMARY KEY(music_style_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, news_category_id INT NOT NULL, title VARCHAR(255) NOT NULL, news_content VARCHAR(600) NOT NULL, news_date DATETIME NOT NULL, INDEX IDX_1DD399503B732BAD (news_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_category (id INT AUTO_INCREMENT NOT NULL, category VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partner (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, url_logo VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_312B3E1612469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partner_category (id INT AUTO_INCREMENT NOT NULL, category VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE concert ADD CONSTRAINT FK_D57C02D249ABEB17 FOREIGN KEY (band_id) REFERENCES band (band_id)');
        $this->addSql('ALTER TABLE concert ADD CONSTRAINT FK_D57C02D22298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE faq_content ADD CONSTRAINT FK_E5B45BF2D823E37A FOREIGN KEY (section_id) REFERENCES faq_category (id)');
        $this->addSql('ALTER TABLE map_point ADD CONSTRAINT FK_3753BC4837769206 FOREIGN KEY (map_point_category_id) REFERENCES map_points_category (map_point_category_id)');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD399503B732BAD FOREIGN KEY (news_category_id) REFERENCES news_category (id)');
        $this->addSql('ALTER TABLE partner ADD CONSTRAINT FK_312B3E1612469DE2 FOREIGN KEY (category_id) REFERENCES partner_category (id)');
        $this->addSql('ALTER TABLE band ADD CONSTRAINT FK_48DFA2EB7DDE3C52 FOREIGN KEY (music_style_id) REFERENCES music_style (music_style_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE band DROP FOREIGN KEY FK_48DFA2EB7DDE3C52');
        $this->addSql('ALTER TABLE concert DROP FOREIGN KEY FK_D57C02D249ABEB17');
        $this->addSql('ALTER TABLE concert DROP FOREIGN KEY FK_D57C02D22298D193');
        $this->addSql('ALTER TABLE faq_content DROP FOREIGN KEY FK_E5B45BF2D823E37A');
        $this->addSql('ALTER TABLE map_point DROP FOREIGN KEY FK_3753BC4837769206');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD399503B732BAD');
        $this->addSql('ALTER TABLE partner DROP FOREIGN KEY FK_312B3E1612469DE2');
        $this->addSql('DROP TABLE concert');
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
    }
}
