import AppKit
import Foundation

let arguments = CommandLine.arguments
guard arguments.count == 3 else {
    fputs("Usage: swift make-admin-guide-pdf.swift input.html output.pdf\n", stderr)
    exit(1)
}

let inputURL = URL(fileURLWithPath: arguments[1])
let outputURL = URL(fileURLWithPath: arguments[2])

let htmlData = try Data(contentsOf: inputURL)
let attributed = try NSMutableAttributedString(
    data: htmlData,
    options: [
        .documentType: NSAttributedString.DocumentType.html,
        .characterEncoding: String.Encoding.utf8.rawValue,
        .baseURL: inputURL.deletingLastPathComponent(),
    ],
    documentAttributes: nil
)

let fullRange = NSRange(location: 0, length: attributed.length)
let paragraphStyle = NSMutableParagraphStyle()
paragraphStyle.lineSpacing = 2
paragraphStyle.paragraphSpacing = 6
attributed.addAttribute(.paragraphStyle, value: paragraphStyle, range: fullRange)

let pageWidth: CGFloat = 612
let pageHeight: CGFloat = 792
let margin: CGFloat = 54
let footerHeight: CGFloat = 20
let contentSize = CGSize(width: pageWidth - (margin * 2), height: pageHeight - (margin * 2) - footerHeight)

var mediaBox = CGRect(x: 0, y: 0, width: pageWidth, height: pageHeight)
guard let context = CGContext(outputURL as CFURL, mediaBox: &mediaBox, nil) else {
    fputs("Could not create PDF context\n", stderr)
    exit(1)
}

let textStorage = NSTextStorage(attributedString: attributed)
let layoutManager = NSLayoutManager()
textStorage.addLayoutManager(layoutManager)

var containers: [NSTextContainer] = []
var renderedGlyphs = 0
var pageNumber = 1

while renderedGlyphs < layoutManager.numberOfGlyphs {
    let container = NSTextContainer(size: contentSize)
    container.lineFragmentPadding = 0
    containers.append(container)
    layoutManager.addTextContainer(container)

    let glyphRange = layoutManager.glyphRange(for: container)
    if glyphRange.length == 0 {
        break
    }

    context.beginPDFPage(nil)
    NSGraphicsContext.saveGraphicsState()
    context.saveGState()
    context.translateBy(x: 0, y: pageHeight)
    context.scaleBy(x: 1, y: -1)
    NSGraphicsContext.current = NSGraphicsContext(cgContext: context, flipped: false)

    NSColor.white.setFill()
    CGRect(x: 0, y: 0, width: pageWidth, height: pageHeight).fill()

    let drawPoint = CGPoint(x: margin, y: margin)
    layoutManager.drawBackground(forGlyphRange: glyphRange, at: drawPoint)
    layoutManager.drawGlyphs(forGlyphRange: glyphRange, at: drawPoint)

    let footer = "Admin Operations Guide  |  Page \(pageNumber)"
    let footerAttributes: [NSAttributedString.Key: Any] = [
        .font: NSFont.systemFont(ofSize: 9),
        .foregroundColor: NSColor(calibratedRed: 0.45, green: 0.50, blue: 0.60, alpha: 1),
    ]
    footer.draw(
        at: CGPoint(x: margin, y: pageHeight - margin + 12),
        withAttributes: footerAttributes
    )

    context.restoreGState()
    NSGraphicsContext.restoreGraphicsState()
    context.endPDFPage()

    renderedGlyphs = glyphRange.location + glyphRange.length
    pageNumber += 1
}

context.closePDF()
print(outputURL.path)
