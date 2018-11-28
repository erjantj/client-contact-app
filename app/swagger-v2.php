Swagger settings:
<?php
/**
 * @SWG\Swagger(
 *     schemes={"http"},
 *     basePath="/api/v1",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Client contact app",
 *         description="Client contact app",
 *         @SWG\Contact(
 *             email="yerzhan.torgayev@gmail.com"
 *         ),
 *     ),
 * )
 */
;?>

Security schemes:
<?php
/**
 *  @SWG\SecurityScheme(
 *   securityDefinition="apiKey",
 *   type="apiKey",
 *   in="header",
 *   name="Authorization"
 * )
 */
;?>


Responses:
<?php
/**
 * @SWG\Response(
 *   response="UnprocessableEntity",
 *   description="Unprocessable Entity"
 * ),
 * @SWG\Response(
 *   response="Forbidden",
 *   description="Forbidden"
 * ),
 * @SWG\Response(
 *   response="RecordNotFound",
 *   description="Record Not Found"
 * )
 */
;?>


Defenitions:
Client
<?php
/**
 * @SWG\Definition(
 *   definition="Client",
 *   @SWG\Property(
 *      property="first_name",
 *      type="string",
 *      description="First name",
 *      default=""
 *   ),
 *   @SWG\Property(
 *      property="last_name",
 *      type="string",
 *      description="Last name",
 *      default=""
 *   ),
 *   @SWG\Property(
 *      property="email",
 *      type="string",
 *      description="Email",
 *      default=""
 *   ),
 * )
 */
;?>

ClientContact
<?php
/**
 * @SWG\Definition(
 *   definition="ClientContact",
 *   @SWG\Property(
 *      property="address",
 *      type="string",
 *      description="Address",
 *      default=""
 *   ),
 *   @SWG\Property(
 *      property="postcode",
 *      type="string",
 *      description="Postcode",
 *      default=""
 *   ),
 * )
 */
;?>