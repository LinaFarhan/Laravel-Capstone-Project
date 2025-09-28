<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $beneficiary_id
 * @property string $type
 * @property string $description
 * @property string $status
 * @property string|null $document_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $beneficiary
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Distribution> $distributions
 * @property-read int|null $distributions_count
 * @method static \Database\Factories\AidRequestFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AidRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AidRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AidRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AidRequest whereBeneficiaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AidRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AidRequest whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AidRequest whereDocumentUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AidRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AidRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AidRequest whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AidRequest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAidRequest {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $volunteer_id
 * @property int $beneficiary_id
 * @property int $donation_id
 * @property string $delivery_status
 * @property string|null $proof_file
 * @property string|null $notes
 * @property int $aid_request_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AidRequest $aidRequest
 * @property-read \App\Models\User $beneficiary
 * @property-read \App\Models\Donation $donation
 * @property-read \App\Models\User $volunteer
 * @method static \Database\Factories\DistributionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution whereAidRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution whereBeneficiaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution whereDeliveryStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution whereDonationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution whereProofFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution whereVolunteerId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperDistribution {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $donor_name
 * @property string $type
 * @property int $quantity
 * @property string $status
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Distribution> $distributions
 * @property-read int|null $distributions_count
 * @method static \Database\Factories\DonationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereDonorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperDonation {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $type
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property string $data
 * @property string|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereNotifiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereNotifiableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperNotification {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $role
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $document_path
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AidRequest> $aidRequests
 * @property-read int|null $aid_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Distribution> $distributions
 * @property-read int|null $distributions_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Distribution> $volunteerDistributions
 * @property-read int|null $volunteer_distributions_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDocumentPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

