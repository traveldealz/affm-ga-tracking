<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class CoyotoAffiliateTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://campaign.mobility-ads.de/autohaus,koenig_1.html?idPartner=167&idCampaignAd=0' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://campaign.mobility-ads.de/autohaus,koenig_1.html?idPartner=167&idCampaignAd=0&subIdentifier=test123', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid( 'https://campaign.mobility-ads.de/autohaus,koenig_1.html?idPartner=167&idCampaignAd=0&deeplink=https%3A%2F%2Fwww.autohaus-koenig.de%2Faktionen%2Frenault-testleasings%2F' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://campaign.mobility-ads.de/autohaus,koenig_1.html?idPartner=167&idCampaignAd=0&deeplink=https%3A%2F%2Fwww.autohaus-koenig.de%2Faktionen%2Frenault-testleasings%2F&subIdentifier=test123', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://campaign.mobility-ads.de/autohaus,koenig_1.html?idPartner=167&idCampaignAd=0&subIdentifier=Test' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://campaign.mobility-ads.de/autohaus,koenig_1.html?idPartner=167&idCampaignAd=0&subIdentifier=Test', $url );
	}

	public function test_existing_subid_but_empty_will_be_overwritten() {
		$Subid = new Subid( 'https://campaign.mobility-ads.de/autohaus,koenig_1.html?idPartner=167&subIdentifier=&idCampaignAd=0' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://campaign.mobility-ads.de/autohaus,koenig_1.html?idPartner=167&subIdentifier=test123&idCampaignAd=0', $url );
	}

}