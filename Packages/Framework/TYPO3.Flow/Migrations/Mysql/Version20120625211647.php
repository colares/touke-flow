<?php
namespace TYPO3\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Add table for publishing configurations and the connection
 * between Resource and AbstractPublishingConfiguration
 */
class Version20120625211647 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("CREATE TABLE typo3_flow3_resource_publishing_abstractpublishingconfiguration (flow3_persistence_identifier VARCHAR(40) NOT NULL, dtype VARCHAR(255) NOT NULL, PRIMARY KEY(flow3_persistence_identifier)) ENGINE = InnoDB");

		$this->addSql("ALTER TABLE typo3_flow3_resource_resource ADD publishingconfiguration VARCHAR(40) DEFAULT NULL");
		$this->addSql("ALTER TABLE typo3_flow3_resource_resource ADD CONSTRAINT FK_B4D45B32A4A851AF FOREIGN KEY (publishingconfiguration) REFERENCES typo3_flow3_resource_publishing_abstractpublishingconfiguration (flow3_persistence_identifier)");
		$this->addSql("CREATE INDEX IDX_B4D45B32A4A851AF ON typo3_flow3_resource_resource (publishingconfiguration)");

		$this->addSql("ALTER TABLE typo3_flow3_security_authorization_resource_securitypubli_6180a ADD CONSTRAINT FK_234846D521E3D446 FOREIGN KEY (flow3_persistence_identifier) REFERENCES typo3_flow3_resource_publishing_abstractpublishingconfiguration (flow3_persistence_identifier) ON DELETE CASCADE");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("ALTER TABLE typo3_flow3_resource_resource DROP FOREIGN KEY FK_B4D45B32A4A851AF");
		$this->addSql("DROP INDEX IDX_B4D45B32A4A851AF ON typo3_flow3_resource_resource");
		$this->addSql("ALTER TABLE typo3_flow3_resource_resource DROP publishingconfiguration");

		$this->addSql("ALTER TABLE typo3_flow3_security_authorization_resource_securitypubli_6180a DROP FOREIGN KEY FK_234846D521E3D446");

		$this->addSql("DROP TABLE typo3_flow3_resource_publishing_abstractpublishingconfiguration");
	}
}

?>