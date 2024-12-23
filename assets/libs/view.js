const { Fragment } = wp.element;
const { __ } = wp.i18n;
const { BaseControl, Button } = wp.components;
const { RichText, MediaUpload, URLInput } = wp.blockEditor;

export default ({ props }) => {
	const {
		attributes: {
			title,
			content,
			backgroundImage,
			paddingTop,
			paddingRight,
			paddingBottom,
			paddingLeft,
			backgroundSize,
			backgroundAttachment,
			backgroundPositionX,
			backgroundPositionY,
			backgroundRepeat,
			backgroundColor,
			titleColor,
			contentColor,
			contentPosition,
			placeHolder,
			buttonLabel,
			newsletterLink,
		},
		setAttributes,
		className,
		isSelected,
	} = props;

	const onChangeTitle = (value) => {
		setAttributes({ title: value });
	};

	const onChangeContent = (newContent) => {
		setAttributes({ content: newContent });
	};

	const onChangePlaceholder = (value) => {
		setAttributes({ placeHolder: value });
	};

	const onChangeButtonLabel = (value) => {
		setAttributes({ buttonLabel: value });
	};

	const handleMediaSelect = (uploadedImage) => {
		setAttributes({
			backgroundImage: uploadedImage.url,
		});
	};

	const blockPadding = {
		'--desktop-padding-top': paddingTop.desktop + 'px',
		'--laptop-padding-top': paddingTop.laptop + 'px',
		'--tab-padding-top': paddingTop.tab + 'px',
		'--mobile-padding-top': paddingTop.mobile + 'px',
		'--desktop-padding-right': paddingRight.desktop + 'px',
		'--laptop-padding-right': paddingRight.laptop + 'px',
		'--tab-padding-right': paddingRight.tab + 'px',
		'--mobile-padding-right': paddingRight.mobile + 'px',
		'--desktop-padding-bottom': paddingBottom.desktop + 'px',
		'--laptop-padding-bottom': paddingBottom.laptop + 'px',
		'--tab-padding-bottom': paddingBottom.tab + 'px',
		'--mobile-padding-bottom': paddingBottom.mobile + 'px',
		'--desktop-padding-left': paddingLeft.desktop + 'px',
		'--laptop-padding-left': paddingLeft.laptop + 'px',
		'--tab-padding-left': paddingLeft.tab + 'px',
		'--mobile-padding-left': paddingLeft.mobile + 'px',
	};

	let bgStyles = {
		backgroundColor: backgroundColor,
	};
	if (backgroundImage) {
		bgStyles = {
			backgroundImage: `url(${backgroundImage})`,
			backgroundSize: backgroundSize,
			backgroundAttachment: backgroundAttachment,
			backgroundPositionX: backgroundPositionX,
			backgroundPositionY: backgroundPositionY,
			backgroundRepeat: backgroundRepeat,
			backgroundColor: backgroundColor,
		};
	}

	return (
		<Fragment>
			<div
				className={`listbook-block-spacing-wrapper listbook-fluid-block ${className}`}
				style={blockPadding}
			>
				<div
					className="listbook-newsletter-block"
					style={{
						justifyContent:
							contentPosition == 'right' ? 'flex-end' : 'flex-start',
					}}
				>
					<div className="listbook-newsletter-block-content">
						<RichText
							tagName="h2"
							className="listbook-newsletter-block-title"
							value={title}
							onChange={onChangeTitle}
							placeholder={__('Enter your title', 'listbook-helper')}
							style={{ color: titleColor }}
						/>
						<RichText
							tagName="p"
							className="listbook-newsletter-block-description"
							onChange={onChangeContent}
							value={content}
							placeholder={__('Enter your content here...', 'listbook-helper')}
							style={{ color: contentColor }}
						/>
						<div className="listbook-newsletter-form">
							<RichText
								tagName="div"
								className="listbook-newsletter-form-input"
								onChange={onChangePlaceholder}
								value={placeHolder}
							/>
							<RichText
								tagName="div"
								className="listbook-newsletter-form-button"
								onChange={onChangeButtonLabel}
								value={buttonLabel}
							/>
						</div>
						{isSelected ? (
							<Fragment>
								<MediaUpload
									buttonProps={{
										className: 'change-image',
									}}
									onSelect={handleMediaSelect}
									allowed={['image']}
									type="image"
									render={({ open }) => {
										return (
											<Fragment>
												<Button isPrimary className="update-bg" onClick={open}>
													{!backgroundImage ? 'Upload' : 'Update'} Background
													Image
												</Button>
											</Fragment>
										);
									}}
								></MediaUpload>
								{backgroundImage ? (
									<Button
										isLink
										isDestructive
										className="update-bg"
										style={{ marginLeft: '10px' }}
										onClick={() => {
											setAttributes({
												backgroundImage: '',
											});
										}}
									>
										Remove
									</Button>
								) : null}
							</Fragment>
						) : null}
					</div>
					<div className="listbook-newsletter-block-bg" style={bgStyles} />
				</div>
			</div>
		</Fragment>
	);
};
