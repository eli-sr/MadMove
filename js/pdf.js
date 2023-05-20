function GeneratePDF (reserva) {
  const ob = {
    outputType: 'save',
    returnJsPDFDocObject: true,
    fileName: 'Reserva',
    orientationLandscape: false,
    compress: true,
    logo: {
      src: 'https://raw.githubusercontent.com/edisonneza/jspdf-invoice-template/demo/images/logo.png',
      width: 53.33, // asprrect ratio = width/height
      height: 26.66,
      margin: {
        top: 0, // negative or positive num, from the current position
        left: 0 // negative or positive num, from the current position
      }
    },
    stamp: {
      inAllPages: true,
      src: 'https://raw.githubusercontent.com/edisonneza/jspdf-invoice-template/demo/images/qr_code.jpg',
      width: 20, // aspect ratio = width/height
      height: 20,
      margin: {
        top: 0, // negative or positive num, from the current position
        left: 0 // negative or positive num, from the current position
      }
    },
    business: {
      name: 'MadMove',
      address: 'Av. Cataluña, s/n, 31006 Pamplona, Navarra',
      email: 'support@madmove.com',
      website: 'www.madmove.com'
    },
    contact: {
      label: 'Rerserva solicitada por:',
      name: reserva.user.name + ' ' + reserva.user.surname,
      address: reserva.user.user,
      email: reserva.user.id + ''
    },
    invoice: {
      label: 'Reserva #: ',
      num: reserva.parkingId,
      invDate: `Fecha: ${reserva.fecha} ${reserva.hora}`,

      header: [
        { title: '#', style: { width: 10 } },
        { title: 'Nombre', style: { width: 30 } },
        { title: 'Dirección', style: { width: 40 } },
        { title: 'Espacios libres', style: { width: 30 } },
        { title: 'Espacios totales', style: { width: 30 } },
        { title: 'Fecha' },
        { title: 'Hora' }
      ],
      table: Array.from(Array(1), (item, index) => [
        reserva.parkingId,
        reserva.nombre,
        reserva.direccion,
        reserva.espacioLibre,
        reserva.espacioTotal,
        reserva.fecha,
        reserva.hora
      ]),
      invDescLabel: 'Términos de uso',
      invDesc:
        'Descargo de responsabilidad:  Al utilizar nuestro servicio de reserva de estacionamiento en línea, usted acepta los siguientes términos y condiciones. Por favor, tómese un momento para leer y comprender esta declaración antes de utilizar nuestro servicio.  Nuestro servicio tiene como objetivo facilitar la reserva anticipada de espacios de estacionamiento en ubicaciones específicas. Sin embargo, es importante tener en cuenta que la disponibilidad de los espacios está sujeta a cambios y no podemos garantizar que su reserva se mantenga vigente hasta su llegada.  En caso de que no acceda al estacionamiento dentro de los 30 minutos posteriores al horario de inicio de su reserva, nos reservamos el derecho de desactivar su reserva. Esta medida se implementa para permitir la reasignación del espacio a otros usuarios o debido a condiciones operativas.  Le recordamos que es su responsabilidad llegar al estacionamiento dentro del plazo establecido para evitar que su reserva se desactive. No asumimos responsabilidad por retrasos, imprevistos o circunstancias que puedan impedir su llegada dentro del tiempo estipulado.'
    },
    footer: {
      text: 'La rerserva es creada automáticamente y es valida sin necesidad de una firma o sello'
    },
    pageEnable: true,
    pageLabel: 'Página'
  }

  const props = ob
  try {
    eval('props = ' + props)
  } catch {
    console.error('Error en generar PDF')
  }
  jsPDFInvoiceTemplate.default(props)
}
