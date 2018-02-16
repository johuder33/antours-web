<!--
    parameters:
    SLOGAN: slogan text
    LOGO_URL: logo url
    MESSAGE: message for email
    PHONES: phones numbers
    YEAR: year

    COMMUNE: the commune name where start or end the trip
    START_FROM: where trip will start
    END_TO: where trip will end
    ROUND_TRIP: if trip is round trip or not
    PASSANGERS: how many passengers will pick up
    PRICE: the service price
    PASSENGER_FULLNAME: the customer name
    SERVICE_NAME: the service name
    DEPARTURE_DATE: the date that customer will return
    DEPARTURE_TIME: the time that customer will go
    RETURN_DATE: the date that customer will return
    RETURN_TIME: the time that customer will return
-->
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border: 2px solid #d59440; padding: 10px; background: #FFF;">
  <tr>
    <td colspan="2" align="left" style="border-bottom: 1px solid #d59440;">
      <p style="margin: 0; padding: 0; color: #d59440;">
        <span>
          {SLOGAN}
        </span>
      </p>
    </td>
  </tr>
  <tr style="height: 200px; background: #FFF;">
    <td colspan="2" style="height: 200px;">
      <img style="max-width: 100%; width: auto; margin: auto; display:block;" src="{LOGO_URL}" />
    </td>
  </tr>
  
  <tr style="background: #d59440;">
    <td colspan="2">
      <p style="color: #FFF; font-weight: 600; padding: 10px; text-align: justify; margin: 0;">
        {MESSAGE}
      </p>

      <p style="color: #FFF; font-weight: 600; padding: 10px; text-align: justify; margin: 0;">
        Customer {PASSENGER_FULLNAME}
      </p>

      <p style="color: #FFF; font-weight: 600; padding: 10px; text-align: justify; margin: 0;">
        Commune {COMMUNE}
      </p>

      <p style="color: #FFF; font-weight: 600; padding: 10px; text-align: justify; margin: 0;">
        Price {PRICE}
      </p>

      <p style="color: #FFF; font-weight: 600; padding: 10px; text-align: justify; margin: 0;">
        fecha de inicio {DEPARTURE_DATE}
      </p>

      <p style="color: #FFF; font-weight: 600; padding: 10px; text-align: justify; margin: 0;">
        hora de inicio {DEPARTURE_TIME}
      </p>

      <p style="color: #FFF; font-weight: 600; padding: 10px; text-align: justify; margin: 0;">
        hora de retorno {RETURN_TIME}
      </p>

      <p style="color: #FFF; font-weight: 600; padding: 10px; text-align: justify; margin: 0;">
        fecha de retorno {RETURN_DATE}
      </p>

      <p style="color: #FFF; font-weight: 600; padding: 10px; text-align: justify; margin: 0;">
        Passengers {PASSANGERS}
      </p>

      <p style="color: #FFF; font-weight: 600; padding: 10px; text-align: justify; margin: 0;">
        Service {SERVICE_NAME}
      </p>

      <p style="color: #FFF; font-weight: 600; padding: 10px; text-align: justify; margin: 0;">
        IS round trip {ROUND_TRIP}
      </p>

      <p style="color: #FFF; font-weight: 600; padding: 10px; text-align: justify; margin: 0;">
        Trip will start in {START_FROM}
      </p>

      <p style="color: #FFF; font-weight: 600; padding: 10px; text-align: justify; margin: 0;">
        Trip will end in {END_TO}
      </p>
    </td>
  </tr>

  <tr>
    <td colspan="2" style="padding: 10px; 0px;">
      <p style="margin: 0; padding: 0; text-align: center; color: #d59440;">
        {PHONES}
      </p>
    </td>
  </tr>
    <tr>
    <td colspan="2">
      <p style="margin: 0; padding: 0; text-align: center; color: #d59440;">
        Antours - Todos los derechos reservados, {YEAR}
      </p>
    </td>
  </tr>
</table>