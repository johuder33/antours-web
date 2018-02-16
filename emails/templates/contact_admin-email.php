<!--
    parameters:
    slogan: slogan text
    logo_url: logo url
    message: message for email
    phones: phones numbers
    year: year
-->
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border: 2px solid #d59440; padding: 10px; background: #FFF;">
  <tr>
    <td colspan="2" align="left" style="border-bottom: 1px solid #d59440;">
      <p style="margin: 0; padding: 0; color: #d59440;">
        <span>
          {slogan}
        </span>
      </p>
    </td>
  </tr>
  <tr style="height: 200px; background: #FFF;">
    <td colspan="2" style="height: 200px;">
      <img style="max-width: 100%; width: auto; margin: auto; display:block;" src="{logo_url}" />
    </td>
  </tr>
  
  <tr style="background: #d59440;">
    <td colspan="2">
      <p style="color: #FFF; font-weight: 600; padding: 10px; text-align: justify; margin: 0;">
        {message}
      </p>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="padding: 10px; 0px;">
      <p style="margin: 0; padding: 0; text-align: center; color: #d59440;">
        {phones}
      </p>
    </td>
  </tr>
    <tr>
    <td colspan="2">
      <p style="margin: 0; padding: 0; text-align: center; color: #d59440;">
        Antours - Todos los derechos reservados, {year}
      </p>
    </td>
  </tr>
</table>