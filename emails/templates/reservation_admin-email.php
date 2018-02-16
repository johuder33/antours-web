<!--
    parameters:
    SLOGAN: slogan text
    LOGO_URL: logo url
    MESSAGE: message for email
    PHONES: phones numbers
    YEAR: year

    ADDRESS: address to pick up,
    TYPE_DOC: id number customer type,
    ID_NUMBER: id customer number,
    PACKAGE: package title
    PRICE: package price
    FULLNAME: customer fullname
    RESERVATION_ID: reservation id
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
        Numero de reservación {RESERVATION_ID}
      </p>

      <p style="color: #FFF; font-weight: 600; padding: 10px; text-align: justify; margin: 0;">
        Documento {TYPE_DOC} - {ID_NUMBER}
      </p>

      <p style="color: #FFF; font-weight: 600; padding: 10px; text-align: justify; margin: 0;">
        Address {ADDRESS}
      </p>

      <p style="color: #FFF; font-weight: 600; padding: 10px; text-align: justify; margin: 0;">
        Customer {FULLNAME}
      </p>

      <p style="color: #FFF; font-weight: 600; padding: 10px; text-align: justify; margin: 0;">
        Package {PACKAGE}
      </p>

      <p style="color: #FFF; font-weight: 600; padding: 10px; text-align: justify; margin: 0;">
        Price {PRICE}
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